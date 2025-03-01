<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CleanTemporaryFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:clean-temp';

    /**
     * The console clean temporary files for tools.
     *
     * @var string
     */
    protected $description = 'Clean tools temporary uploads & results.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = config('artisan.temporary_files_path', 'temp');
        $diskLocale = config('artisan.temporary_files_disk', 'local');
        $diskPublic = config('artisan.public_files_disk', 'public');

        Storage::disk($diskLocale)->deleteDirectory($path);
        Storage::disk($diskLocale)->makeDirectory($path);

        Storage::disk($diskPublic)->deleteDirectory($path);
        Storage::disk($diskPublic)->makeDirectory($path);

        Cache::forget('temp_files_size');
    }
}
