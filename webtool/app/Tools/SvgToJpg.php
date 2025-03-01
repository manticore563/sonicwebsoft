<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ZanySoft\Zip\Facades\Zip;
use App\Contracts\ToolInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SvgToJpg implements ToolInterface
{
    public function __construct()
    {
        config(['image.driver' => 'imagick']);
    }

    public function render(Request $request, Tool $tool)
    {
        return view('tools.svg-to-jpg', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $request->validate([
            'images' => "required|max:" . ($tool->no_file_tool ?? 1),
            'images.*' => ["required", "mimetypes:image/svg+xml", "max:" . (($tool->fs_tool ?? 1) * 1024)]
        ]);

        $images = $request->file('images');
        $process_id = (string) Str::uuid();

        $files = Cache::remember($process_id, job_cache_time(), function () use ($images) {
            $uploadedFiles = collect();
            foreach ($images as $image) {
                $file = tempFileUpload($image);
                if ($file) {
                    $uploadedFiles->push($file);
                }
            }

            return $uploadedFiles;
        });

        $results = [
            'files' => $files,
            'process_id' => $process_id
        ];

        return view('tools.svg-to-jpg', compact('results', 'tool'));
    }

    public function postAction(Request $request, $tool)
    {
        $action = $request->action;

        switch ($action) {
            case 'process-file':
                $image = $this->processSingleFile($request);
                return $image;
                break;
            case 'download-all':
                return $this->downloadAllImages($request, $tool);
                break;
        }

        abort(404);
    }

    protected function downloadAllImages($request, $tool)
    {
        $process_id = $request->process_id;
        // Get last cached resource
        $result = Cache::get($process_id . "-download-all");
        // Make path for all images
        $path = pathinfo($result['path'])['dirname'];
        $job = Storage::disk($result['disk'])->path($path);

        // Zip store location & path.
        $storeDisk = Storage::disk(config('artisan.temporary_files_disk', 'local'));
        $storePath = config('artisan.temporary_files_path', 'temp') . DIRECTORY_SEPARATOR . $process_id;
        $storeDisk->makeDirectory($storePath);
        $zip = Zip::create($storeDisk->path("{$storePath}/{$tool->slug}.zip"));
        $zip->add($job, true);
        $zip->close();

        return $storeDisk->download("{$storePath}/{$tool->slug}.zip");
    }

    protected function processSingleFile($request)
    {
        if (!class_exists("Imagick")) {
            return response()->json(['status' => false, 'message' => 'The Imagick extension is not installed or enabled.']);
        }

        $validator = Validator::make($request->all(), [
            'process_id' => 'required|uuid',
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => __('tools.invalidRequest')]);
        }

        $process_id = $request->input('process_id');
        $filename = $request->input('file');
        $newEncoding = 'jpg';

        // Fetch Job
        $job = Cache::get($process_id);
        if (!$job) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }
        // Find image in job
        $file = collect($job)->firstWhere('original_filename', $filename);
        if (!$file) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }

        $path = Storage::disk($file['disk'])->path($file['path']);

        // Create an instance of Imagick
        $imagick = new \Imagick();

        // Load the SVG file into Imagick
        $imagick->readImage($path);

        // Set the format to JPG
        $imagick->setImageFormat($newEncoding);

        // Optionally, you can set a background color (SVGs might have transparent backgrounds)
        $imagick->setImageBackgroundColor('white');

        // Flatten the image to remove any transparency (useful if the SVG has transparency)
        $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
        $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);

        // Get the image blob (the binary content of the image)
        $image = $imagick->getImageBlob();

        // Destroy Imagick resources to free memory
        $imagick->clear();
        $imagick->destroy();

        $filename = (pathinfo($filename, PATHINFO_FILENAME)) . ".{$newEncoding}";
        $resource = UploadedFile::fake()->createWithContent($filename, $image);
        $result = tempFileUpload($resource, true, false, $process_id);

        Cache::put($process_id . "-download-all", $result, job_cache_time());

        return response()->json([
            'success' => true,
            'filename' => $result['original_filename'],
            'size' => $result['size'],
            'url' => url($result['url']),
        ]);
    }
}
