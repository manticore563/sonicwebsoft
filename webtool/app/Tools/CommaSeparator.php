<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class CommaSeparator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.comma-separator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $request->validate(
            [
            'list' => 'required',
            'delimiter' => 'nullable|string',
            'list_suffix' => 'nullable|string',
            'list_prefix' => 'nullable|string',
            'item_prefix' => 'nullable|string',
            'item_suffix' => 'nullable|string',
            ]
        );

        $list_suffix = $request->input('list_suffix');
        $list_prefix = $request->input('list_prefix');
        $reverse = $request->input('reverse', 0);
        $duplicates = $request->input('duplicates', 0);
        $delimiter = $request->input('delimiter');
        $line_breaks = $request->input('line_breaks', 0);
        $list = $request->input('list');

        // Remvoe linebreaks
        if(!empty($delimiter)) {
            $list = explode($delimiter, $list);
        } else if($line_breaks == 1) {
            $list = preg_split('/\r\n|\r|\n/', $list);
        }

        $list = $list_original = collect($list);

        // Remvoe duplicates
        if($duplicates == 1) {
            $list = $list->unique();
        }

        // Reverse list
        if($reverse == 1) {
            $list = $list->reverse();
        }

        $list = $list->filter()->map(
            function ($string) use ($request) {
                $spaces = $request->input('spaces', 0);
                $whitespace = $request->input('whitespace', 0);
                $item_prefix = $request->input('item_prefix', null);
                $item_suffix = $request->input('item_suffix', null);
                $quotes = $request->input('quotes');
                $textcase = $request->input('textcase', 0);

                $quotes = $quotes == 'none'? null : ($quotes == 'single'? "'" : '"');

                // Remvoe double spaces
                if($spaces == 1) {
                    $string = preg_replace('/ {2,}/', ' ', $string);
                }

                // Remvoe double spaces
                if($whitespace == 1) {
                    $string = preg_replace('/\s+/', '', $string);
                }

                $string = trim($string);

                // Lowercase string
                if($textcase == 'lower') {
                    $string = strtolower($string);
                }

                // uppercase string
                if($textcase == 'upper') {
                    $string = strtoupper($string);
                }

                return $item_prefix . $quotes . $string . $quotes . $item_suffix;
            }
        );

        if(!empty($list_prefix)) {
            $list->prepend($list_prefix);
        }

        if(!empty($list_suffix)) {
            $list->push($list_suffix);
        }

        $results['output'] = $list->implode("\n\t");
        $results['list'] = $request->input('list');
        $results['collection'] = $list;
        $results['item_prefix'] = $request->item_prefix;
        $results['item_suffix'] = $request->item_suffix;
        $results['list_suffix'] = $request->list_suffix;
        $results['list_prefix'] = $request->list_prefix;
        $results['delimiter'] = $delimiter;

        return view('tools.comma-separator', compact('results', 'tool'));
    }
}
