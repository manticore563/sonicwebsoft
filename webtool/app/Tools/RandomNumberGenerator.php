<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class RandomNumberGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.number-generator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'lower_limit' => 'required|min:1',
            'upper_limit' => 'required|min:1|gt:lower_limit',
            'limit' => 'required|integer|min:1|max:100',
            'type' => 'required'
        ]);

        $lower_limit = $request->input('lower_limit');
        $upper_limit = $request->input('upper_limit');
        $limit = $request->input('limit');
        $type = $request->input('type');

        $numbers = collect();

        for ($i = 1; $i <= $limit; $i++) {
            $number = $type == 'integer' ? rand($lower_limit, $upper_limit) : $this->random_float($lower_limit, $upper_limit);
            $numbers->push($number);
        }

        $results['numbers'] = $numbers;
        $results['copy'] = $numbers->implode("\n");

        return view('tools.number-generator', compact('lower_limit', 'upper_limit', 'limit', 'type', 'results', 'tool'));
    }

    private function random_float($min, $max)
    {
        return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX);
    }
}
