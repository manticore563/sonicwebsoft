<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class JsonBeautifier implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.json-beautifier', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        abort(404);
    }


}
