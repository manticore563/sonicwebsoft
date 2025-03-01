<?php

namespace App\Components\Drivers;

use App\Models\Tool;
use Illuminate\Support\Facades\Cache;
use App\Contracts\ToolDriverInterface;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Coordinate\Dimension;

class FfmpegDriver implements ToolDriverInterface
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
        $ffmpegPath = $this->settings->ffmpeg_path ?? 'ffmpeg';
        $ffprobePath = $this->settings->ffprobe_path ?? 'ffprobe';

        // Fetch file
        $file = Cache::get($process_id);
        if (!$file) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }

        // Find Video in file
        if (!isset($file['original_filename'])) {
            return response()->json(['status' => false, 'message' => __('tools.theRequestExpired')]);
        }

        // Video store path
        $path = config('artisan.temporary_files_path', 'temp') . DIRECTORY_SEPARATOR . $process_id . DIRECTORY_SEPARATOR;
        $disk = config('artisan.public_files_disk', 'public');

        Storage::disk($disk)->makeDirectory($path);

        // Paths for the video
        $pathOfVideo = Storage::disk($file['disk'])->path($file['path']);
        $originalFilenameWithoutExt = pathinfo($file['original_filename'], PATHINFO_FILENAME);
        $gifFilename = $originalFilenameWithoutExt . '.gif';
        $gifPath = $path . $gifFilename;
        $fullGifPath = Storage::disk($disk)->path($gifPath);

        // Convert video to GIF (full video length, original resolution)
        try {
            // Create an FFmpeg instance
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => $ffmpegPath,
                'ffprobe.binaries' => $ffprobePath,
            ]);

            // Open the video file
            $video = $ffmpeg->open($pathOfVideo);

            // Use ffprobe to get video duration and dimensions
            $ffprobe = $ffmpeg->getFFProbe();
            $videoStream = $ffprobe
                ->streams($pathOfVideo) // Extract the stream data from the video
                ->videos()              // Filter video streams
                ->first();              // Get the first video stream (assuming single video stream)

            $duration = $videoStream->get('duration'); // Get the duration in seconds
            $width = $videoStream->get('width');       // Get the width of the video
            $height = $videoStream->get('height');     // Get the height of the video

            if ($duration && $width && $height) {
                // Convert the entire video to GIF at original resolution
                $video
                    ->gif(
                        TimeCode::fromSeconds(0),              // Start from 0 seconds
                        new Dimension($width, $height),        // Use original dimensions
                        (int)$duration                         // Full duration of the video
                    )
                    ->save($fullGifPath);

                // Get file size
                $fileSize = Storage::disk($disk)->size($gifPath);

                // Get full URL to the GIF file
                $gifUrl = str_replace('\\', '/', Storage::disk($disk)->url($gifPath));

                return [
                    'status' => true,
                    'message' => 'Video successfully converted to GIF',
                    'filename' => $gifFilename,
                    'filesize' => $fileSize,
                    'url' => url($gifUrl),
                ];
            } else {
                return [
                    'status' => false,
                    'message' => __('tools.failedToGetVideoDuration'),
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => __('tools.failedToConvertVideoError'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
