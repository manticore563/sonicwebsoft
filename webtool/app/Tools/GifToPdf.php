<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Traits\ToolsPostAction;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Traits\GhostscriptFields;

class GifToPdf implements ToolInterface
{
    use GhostscriptFields, ToolsPostAction;

    public function render(Request $request, Tool $tool)
    {
        return view('tools.gif-to-pdf', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'mimes:gif',
            'margin' => 'required',
            'page_orientation' => 'required',
            'page_size' => 'required',
            'merge_pages' => 'nullable',
        ]);

        $request->request->add(['convert_to' => 'jpg']);
        $request->request->add(['output' => 'pdf']);
        $request->request->add(['filename' => $tool->slug]);
        $request->request->add(['device' => 'pdfwrite']);
        $request->request->add(['arguments' => ['viewjpeg.ps']]);
        $driver = (new ToolsManager($tool))->driver();
        if (method_exists($driver, 'setTask')) {
            $driver->setTask('imagepdf');
        }
        $results = $driver->parse($request);

        if (!$results['files']) {
            return redirect()->back()->withErrors(__('common.somethingWentWrong'));
        }

        return view('tools.gif-to-pdf', compact('tool', 'results'));
    }
}
