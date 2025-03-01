<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ZanySoft\Zip\Facades\Zip;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JpgToSvg implements ToolInterface
{
    protected $extensions = 'jpg,jpeg';
    protected $allowedExtensions = '.jpg,.jpeg';

    public function render(Request $request, Tool $tool)
    {
        $extensions = $this->allowedExtensions;

        return view('tools.svg-converter', compact('tool', 'extensions'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'images' => "required|max:" . ($tool->no_file_tool ?? 1),
            'images.*' => "image|mimes:{$this->extensions}|max:" . (($tool->fs_tool ?? 1) * 1024)
        ]);

        $images = $request->file('images');
        $process_id = (string) Str::uuid();
        $extensions = $this->allowedExtensions;

        $files = Cache::remember($process_id, job_cache_time(), function () use ($images, $process_id) {
            $uploadedFiles = collect();
            foreach ($images as $image) {
                $file = tempFileUploadConverter($image, 'bmp', false, false, $process_id);
                $file['original_filename'] = $image->getClientOriginalName();
                $file['filename'] = filenameWithoutExtension($image->getClientOriginalName()) . '.svg';
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

        return view('tools.svg-converter', compact('results', 'tool', 'extensions'));
    }

    public function postAction(Request $request, $tool)
    {
        $action = $request->action;

        switch ($action) {
            case 'process-file':
                $image = $this->processSingleFile($request, $tool);
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

    protected function processSingleFile(Request $request, Tool $tool)
    {
        $validator = Validator::make($request->all(), [
            'process_id' => 'required|uuid',
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => __('tools.invalidRequest')]);
        }

        $driver = (new ToolsManager($tool))->driver();
        $result = $driver->parse($request);

        return response()->json($result);
    }

    public static function getFileds()
    {
        $array = [
            'title' => "Drivers",
            'fields' => [
                [
                    'id' => "driver",
                    'field' => "tool-options-select",
                    'placeholder' => "Driver",
                    'label' => "Driver",
                    'required' => true,
                    'options' => [['text' => "Potrace", 'value' => "Potrace"]],
                    'validation' => "required",
                    'type' => 'dropdown',
                    'classes' => "",
                    'dependant' => null,
                ],
                [
                    'id' => "potrace_path",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Enter Potrace binary path",
                    'label' => "Potrace Path",
                    'required' => true,
                    'options' => null,
                    'validation' => "required_if:driver,Potrace",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "Potrace"],
                ],
                [
                    'id' => "mkbitmap_path",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Enter mkbitmap binary path",
                    'label' => "MKBitmap Path (optional)",
                    'required' => false,
                    'options' => null,
                    'validation' => "nullable",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "Potrace"],
                ],
            ],
            "default" => ['driver' => 'Potrace', 'potrace_path' => 'potrace', 'mkbitmap_path' => null]
        ];

        return $array;
    }
}
