<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;
use App\Helpers\Classes\SEOAnalyzer;

class WordCounter implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.word-counter', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'string' => "required|min:1|max_words:{$tool->wc_tool}",
        ]);

        $string = trim($request->input('string'));
        $results['string'] = $string;
        $results['words'] = str_word_count($string);
        $results['sentences'] = $this->countSentences($string);
        $results['read_time'] = $this->readTime($string);
        $results['speaking_time'] = $this->speakingTime($string);
        $results['characters'] = strlen($string);
        $results['characters_wos'] = strlen($string) - substr_count($string, ' ');
        $results['syllables'] = $this->countSyllables($string);
        $results['paragraph'] = $this->longestParagraph($string);
        $results['one'] = $this->getKeywordDetails($string, 1, 1);
        $results['two'] = $this->getKeywordDetails($string, 2, 1);
        $results['three'] = $this->getKeywordDetails($string, 3, 1);

        return view('tools.word-counter', compact('results', 'tool'));
    }

    private function getKeywordDetails($string, $len, $min)
    {
        $analyzer = new SEOAnalyzer();
        $total = str_word_count($string);
        $words = collect($analyzer->getKeywordDetails($string, $len, $min))
            ->map(function ($word) use ($total) {
                $word['percentage'] = $word['frequency'] > 0 ? (($word['frequency'] * $total) / 100) : 0;

                return $word;
            })
            ->toArray();


        return $words;
    }

    private function countSentences($string)
    {
        return count(explode('.', rtrim($string, '.')));
    }

    private function longestParagraph($string)
    {
        $sentences = collect(explode('.', rtrim($string, '.')))
            ->map(function ($str) {
                return [
                    'string' => trim($str),
                    'words' => str_word_count($str),
                    'characters' => strlen($str),
                ];
            })
            ->sortByDesc('characters')
            ->first();

        return $sentences;
    }

    private function countSyllables($string)
    {
        preg_match_all('/tion|Uni|ver|si|ty|[aeiou]/', $string, $matches);

        return count($matches[0]);
    }

    private function readTime($string)
    {
        $word = str_word_count(strip_tags($string));
        $m = floor($word / 230);
        $s = floor($word % 230 / (230 / 60));
        if ($s > 30) {
            $m++;
        }

        return trans_choice('common.timeMinutes', $m);
    }

    private function speakingTime($string)
    {
        $word = str_word_count(strip_tags($string));
        $m = floor($word / 100);
        $s = floor($word % 100 / (100 / 60));
        if ($s > 20) {
            $m++;
        }

        return trans_choice('common.timeMinutes', $m);
    }
}
