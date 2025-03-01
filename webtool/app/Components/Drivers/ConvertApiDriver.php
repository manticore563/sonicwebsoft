<?php

namespace App\Components\Drivers;

use App\Models\Tool;
use ConvertApi\ConvertApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ConvertApiDriver
{
    protected $files = [];
    protected $tool;

    public function __construct(Tool $tool)
    {
        $this->tool = $tool;
    }

    public function parse($request)
    {
        $success = true;
        $files = $request->file('files');
        $format = $request->input('format', 'xlsx');
        if (empty($this->tool->settings->convert_api_secret) || empty($this->tool->settings->convert_api_key)) {
            $message = __('common.apiKeyNotProvided');
            $success = false;

            return compact('message', 'success');
        }
        ConvertApi::setApiSecret($this->tool->settings->convert_api_secret);

        $process_id = (string) Str::uuid();
        $files = Cache::remember($process_id, job_cache_time(), function () use ($files, $format, $process_id) {
            Storage::disk('public')->makeDirectory("temp/{$process_id}");
            $processedDir = Storage::disk('public')->path("temp/{$process_id}");

            $uploads = collect();
            $results = [];
            foreach ($files as $file) {
                $uploadedFile = tempFileUpload($file, false, false, $process_id);
                $uploads->push(['File' => Storage::disk($uploadedFile['disk'])->path($uploadedFile['path'])]);
                $result = ConvertApi::convert($format, ['File' => Storage::disk($uploadedFile['disk'])->path($uploadedFile['path'])], 'pdf');
                $result->saveFiles($processedDir);

                $results[] = [
                    'filename' => $result->getFile()->getFileName(),
                    'url' =>  url('storage/temp/' . $process_id . '/' . $result->getFile()->getFileName()),
                    'size' => $result->getFile()->getFileSize(),
                ];
            }

            return $results;
        });

        return compact('process_id', 'files', 'success');
    }
}
