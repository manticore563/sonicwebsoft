<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;
use App\Helpers\Classes\LoremIpsum;

class LoremIpsumGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.lorem-ipsum-generator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'type' => 'required|in:paragraph,words,list,sentences',
            'limit' => 'required|integer|min:1|max:500',
        ]);

        $start = $request->input('start', 0);
        $type = $request->input('type');
        $limit = $request->input('limit');
        $lipsum = new LoremIpsum();
        if ($start != 1) {
            $lipsum->setFirst(false);
        }
        $content = null;
        if ($type == 'paragraph') {
            $content = $lipsum->paragraphs($limit, 'p');
        } else if ($type == 'words') {
            $content = $lipsum->words($limit, 'p');
        } else if ($type == 'list') {
            $content = $lipsum->lists($limit, 'li');
        } else if ($type == 'sentences') {
            $content = $lipsum->sentences($limit, 'p');
        }

        $results['content'] = $content;

        return view('tools.lorem-ipsum-generator', compact('limit', 'type', 'start', 'results', 'tool'));
    }
}
