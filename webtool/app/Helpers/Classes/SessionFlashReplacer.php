<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Blade;
use Spatie\ResponseCache\Replacers\Replacer;
use Symfony\Component\HttpFoundation\Response;

class SessionFlashReplacer implements Replacer
{
    protected string $replacementString = '<monster-tools-responsecache-messages-here>';
    protected string $searchString = '/<div class="toast-container[^>]*>(.*?)<\/div>/s';

    public function prepareResponseToCache(Response $response): void
    {
        if (!$response->getContent()) {
            return;
        }

        $response->setContent(preg_replace(
            $this->searchString,
            $this->replacementString,
            $response->getContent()
        ));
    }

    public function replaceInCachedResponse(Response $response): void
    {
        if (!$response->getContent()) {
            return;
        }
        $replacementString = '';
        if (session('success') || session('error') || session('errors')) {
            $replacementString = Blade::render('<x-application-messages />');
        }
        $response->setContent(str_replace(
            $this->replacementString,
            $replacementString,
            $response->getContent()
        ));
    }
}
