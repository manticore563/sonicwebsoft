<?php

namespace App\Components\Drivers;

use Exception;
use App\Models\Tool;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Contracts\ToolDriverInterface;
use GuzzleHttp\Exception\ClientException;

class MozApiDriver implements ToolDriverInterface
{
    private $tool;
    private $domain;

    public function __construct(Tool $tool)
    {
        $this->tool = $tool;
    }

    public function parse($domain)
    {
        $this->domain = $domain;
        $cacheKey = empty($domain) ? (string) Str::uuid() : Str::slug($domain);
        try {
            if (!isset($this->tool->settings->moz_token) || empty($this->tool->settings->moz_token)) {
                throw new Exception(__('common.apiKeyNotProvided'));
            }

            $info = Cache::remember($cacheKey, 3600, function () use ($domain) {
                $token = $this->tool->settings->moz_token ?? null;
                $expires = time() + 300;
                $cols = "103079233568";
                $endpoint = "http://lsapi.seomoz.com/linkscape/url-metrics/" . urlencode($domain) . "?Cols=" . $cols . "&Expires=" . $expires ;
                $client = new Client();
                $response = $client->request('GET', $endpoint, [
                    'headers' => [
                        'x-moz-token' => $token,
                        'Content-Type' => 'application/json',
                    ],
                ]);
                $json = $response->getBody()->getContents();
                $info = json_decode($json, TRUE);

                return $info;
            });

            $content = $this->results($info);

            return compact('domain', 'content');
        } catch (ClientException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            $info = json_decode($responseBody, true);
            $message = $info['error']['message'] ?? __('common.somethingWentWrong');

            return compact('domain', 'message');
        } catch (Exception $e) {
            $message = __('common.somethingWentWrong');

            return compact('domain', 'message');
        }
    }

    protected function results($info)
    {
        return  [
            'ip' => $this->domain,
            'da' => $info['pda'] ?? 0,
            'pa' => $info['upa'] ?? 0,
            'mr' => $info['umrp'] ?? $info['umrr'] ?? 0,
            'linking' => format_number($info['ueid'] ?? 0),
        ];
    }
}
