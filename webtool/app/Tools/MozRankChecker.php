<?php

namespace App\Tools;

use App\Models\Tool;
use Iodev\Whois\Factory;
use Illuminate\Http\Request;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;


class MozRankChecker implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.moz-rank-checker', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'domain' => 'required|fqdn',
        ]);


        $domain = $request->input('domain');
        $driver = (new ToolsManager($tool))->driver();
        $results = $driver->parse($domain);
        $content = $results['content'] ?? false;

        if (!$content) {
            return redirect()->back()->withError($results['message'] ?? __('common.somethingWentWrong'));
        }

        $results = [
            'domain' => $request->domain,
            'content' => $content
        ];

        return view('tools.moz-rank-checker', compact('results', 'tool'));
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
                    'options' => [['text' => "Default", 'value' => "mozApi"]],
                    'validation' => "required",
                    'type' => 'dropdown',
                    'classes' => "",
                    'dependant' => null,
                ],
                [
                    'id' => "moz_token",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Enter your MOZ API token here....",
                    'label' => "Moz API Token",
                    'required' => true,
                    'options' => null,
                    'validation' => "required_if:driver,mozApi",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "mozApi"],
                ],
            ],

            "default" => ['driver' => 'mozApi']
        ];

        return $array;
    }
}
