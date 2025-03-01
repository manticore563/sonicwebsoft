<?php

namespace App\Tools;

use App\Models\Tool;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;
use App\Helpers\Classes\SEOAnalyzer;
use GuzzleHttp\Exception\RequestException;


class BrokenLinksChecker implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.broken-links-checker', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate(['url' => ['required', 'url']]);

        $url = $request->input('url');

        $client = new SEOAnalyzer;
        $client->setUrl($url);
        $page = $client->getPageContent($url);
        $document = $client->parseHtml($page);
        $urls = $client->doLinkResult($document, false);
        $links = collect($urls['links'])->filter(
            function ($link) {
                return $link['internal'] === true;
            }
        );
        $urls['unique'] = $links->unique('url')->count();
        $results = true;

        return view('tools.broken-links-checker', compact('results', 'url', 'urls', 'links', 'tool'));
    }

    public function postAction(Request $request, $tool)
    {
        if(!$request->wantsJson()) {
            abort(404);
        }

        $request->validate(['link' => ['required', 'url']]);
        $link = $request->input('link');
        $client = new Client();
        $statusCode = null;

        try {
            $response = $client->request('GET', $link);
            $statusCode = $response->getStatusCode();
        } catch (RequestException $e) {
            $statusCode = $e->getCode();
        }

        return response()->json(['status' => true, 'response' => $statusCode]);
    }
}
