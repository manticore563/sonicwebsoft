<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class VideoToGif implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.video-to-gif', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate(['video' => 'required|mimes:mp4,avi,mov,wmv|max:' . ($tool->fs_tool ?? 1) * 1024]);

        $file = $request->file('video');
        $process_id = (string) Str::uuid();

        $file = Cache::remember($process_id, job_cache_time(), function () use ($file) {
            return tempFileUpload($file);
        });

        $results = [
            'file' => $file,
            'process_id' => $process_id
        ];

        return view('tools.video-to-gif', compact('tool', 'results'));
    }

    public function postAction(Request $request, $tool)
    {
        $action = $request->action;

        switch ($action) {
            case 'process-file':
                $validator = Validator::make($request->all(), [
                    'process_id' => 'required|uuid',
                    'file' => 'required'
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => false, 'message' => __('tools.invalidRequest')]);
                }

                $driver = (new ToolsManager($tool))->driver();
                return $driver->parse($request);

                break;
        }

        abort(404);
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
                    'options' => [['text' => "FFMPEG", 'value' => "Ffmpeg"]],
                    'validation' => "required",
                    'type' => 'dropdown',
                    'classes' => "",
                    'dependant' => null,
                ],
                [
                    'id' => "ffmpeg_path",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Enter FFMPEG binary path",
                    'label' => "FFMPEG Path",
                    'required' => true,
                    'options' => null,
                    'validation' => "required_if:driver,Ffmpeg",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "Ffmpeg"],
                ],
                [
                    'id' => "ffprobe_path",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Enter FFPROBE binary path",
                    'label' => "FFPROBE Path",
                    'required' => true,
                    'options' => null,
                    'validation' => "required_if:driver,Ffmpeg",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "Ffmpeg"],
                ],
            ],
            "default" => ['driver' => 'Ffmpeg', 'ffmpeg_path' => 'ffmpeg', 'ffprobe_path' => 'ffmpeg']
        ];

        return $array;
    }
}
