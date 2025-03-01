<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class JsonValidator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.json-validator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        abort(404);
    }
}
