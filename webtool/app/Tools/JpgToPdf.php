<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Traits\GhostscriptFields;
use App\Traits\ToolsPostAction;

class JpgToPdf implements ToolInterface
{
    use GhostscriptFields, ToolsPostAction;

    public function render(Request $request, Tool $tool)
    {
        return view('tools.jpg-to-pdf', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $request->validate([
            'files' => "required|max:{$tool->no_file_tool}",
            'files.*' => "image|mimes:jpg,jpeg|max:" . convert_mb_into_kb($tool->fs_tool),
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

        return view('tools.jpg-to-pdf', compact('tool', 'results'));
    }
}
