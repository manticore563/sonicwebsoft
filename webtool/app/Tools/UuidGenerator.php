<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class UuidGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        $uuid = Str::uuid();

        return view('tools.uuid-generator', compact('tool', 'uuid'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'limit' => 'required|integer|min:1|max:500',
        ]);

        $limit = $request->input('limit');
        $uuids = collect();
        for ($i = 1; $i <= $limit; $i++) {
            $uuids->push(Str::uuid()->toString());
        }

        $results['uuids'] = $uuids->sort();
        $results['copy'] = $uuids->sort()->implode("\n");

        return view('tools.uuid-generator', compact('limit', 'results', 'tool'));
    }

    private function random_float($min, $max)
    {
        return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX);
    }
}
