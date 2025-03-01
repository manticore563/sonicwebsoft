<?php

namespace App\Components\Drivers;

use App\Models\Tool;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Contracts\ToolDriverInterface;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Classes\PotraceConverter;

class PotraceDriver implements ToolDriverInterface
{
    protected $files = [];
    protected $tool;
    protected $settings;

    public function __construct(Tool $tool)
    {
        $this->tool = $tool;
        $this->settings = $tool->settings;
    }

    public function parse($request)
    {
        $process_id = $request->input('process_id');
        $filename = $request->input('file');
        $potracePath = $this->settings->potrace_path ?? 'potrace';
        $mkbitmapePath = $this->settings->mkbitmap_path;

        // Fetch file
        $job = Cache::get($process_id);
        if (!$job) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }

        // Find image in job
        $file = collect($job)->firstWhere('original_filename', $filename);
        if (!$file) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }

        // Video store path
        $path = config('artisan.temporary_files_path', 'temp') . DIRECTORY_SEPARATOR . $process_id . DIRECTORY_SEPARATOR;
        $urlPath = config('artisan.temporary_files_path', 'temp') . '/' . $process_id . '/';
        $disk = config('artisan.public_files_disk', 'public');

        Storage::disk($disk)->makeDirectory($path);

        // Paths for the video
        $pathOfImage = Storage::disk($file['disk'])->path($file['path']);
        $originalFilenameWithoutExt = pathinfo($file['original_filename'], PATHINFO_FILENAME);
        $svgFilename = $originalFilenameWithoutExt . '.svg';
        $svgPath = $path . $svgFilename;
        $fullSvgPath = Storage::disk($disk)->path($svgPath);
        $tempPath = Storage::disk($file['disk'])->path($path);

        // Convert image to svg
        try {
            // Create an instance of PotraceConverter
            $converter = new PotraceConverter();

            // Set input and output files
            $converter->setInputFile($pathOfImage)
                ->setOutputFile($fullSvgPath)
                ->setBinaryPath($potracePath)
                ->setTempDir($tempPath);

            // Enable mkbitmap preprocessing and set mkbitmap options
            $converter->useMkbitmap(!blank($mkbitmapePath))
                ->setMkbitmapPath($mkbitmapePath)       // Optional if mkbitmap is not in PATH
                ->setMkbitmapThreshold(0.5)             // Set threshold for bilevel conversion
                ->setMkbitmapScale(2)                   // Scale the image by a factor of 2
                ->setMkbitmapBlur(1)                    // Apply blur with radius 3
                ->setMkbitmapInvert(true);             // Invert the image if needed

            // Set Potrace options (optional)
            $converter->setTurdSize(2)             // Ignore small features
                ->setAlphaMax(1.0)                 // Curve smoothness
                ->setOptTolerance(0.2)             // Curve optimization
                ->setTurnPolicy('minority')        // Resolve ambiguities
                // ->setFillColor('#f23f5f')          // Set fill color (black)
                ->setGroup(true);                  // Group paths in SVG

            // Run the conversion
            $converter->run();

            return $this->output($process_id, [
                'path' => $svgPath,
                'disk' => $disk,
                'size' => File::size($fullSvgPath),
                'filename' => $svgFilename,
                'url' => generateFileUrl($urlPath . $svgFilename, $disk),
            ]);
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => __('common.somethingWentWrong'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Read the outputDir and return files
     *
     * @return Array|bool
     */
    protected function output(string $process_id, array $result)
    {
        if (!Cache::has($process_id . "-download-all")) {
            Cache::put($process_id . "-download-all", $result, job_cache_time());
        }

        return [
            'success' => true,
            'filename' => $result['filename'],
            'size' => $result['size'],
            'url' => url($result['url']),
        ];
    }
}
