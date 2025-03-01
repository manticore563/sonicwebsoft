<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Rules\MultipleDomainsValidator;
use App\Rules\MultipleMaxlinesValidator;


class GoogleCacheChecker implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.google-cache-checker', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate(['domain' => ['required', new MultipleDomainsValidator, new MultipleMaxlinesValidator($tool->no_domain_tool ?? 1)]]);

        $results = ['domain' => $request->domain, 'domainAddresses' => collect(explode(PHP_EOL, $request->domain))->toJson()];

        return view('tools.google-cache-checker', compact('results', 'tool'));
    }

    public function postAction(Request $request, $tool)
    {
        $domain = $request->input('domain');
        $url = "http://webcache.googleusercontent.com/search?hl=en&q=cache:" . $domain;
        $output = makeHttpRequest($url);

        if (preg_match('/(\d{1,2}\s[a-zA-Z]{3}\s\d{4}\s\d{2}:\d{2}:\d{2}.*?)\./', $output, $mdc)) {
            $content['dt_cache'] = __('tools.cacheDatetimeStr', ['datetime' => $mdc[1]]);
        }

        $content['datetime'] = $mdc[1] ?? '—';
        $results = ['content' => $content ?? false, 'url' => $url];

        return $results;
    }
}
