<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Traits\ToolsPostAction;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Traits\GhostscriptFields;

class PdfToPngConverter implements ToolInterface
{
    use GhostscriptFields, ToolsPostAction;

    public function render(Request $request, Tool $tool)
    {
        return view('tools.pdf-png-converter', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'files' => "required|max:{$tool->no_file_tool}",
            'files.*' => "required|mimes:pdf|max:" . convert_mb_into_kb($tool->fs_tool)
        ]);

        $request->request->add(['is_image_tool' => 'png']);
        $request->request->add(['device' => 'pngalpha']);
        $request->request->add(['output' => 'png']);
        $request->request->add(['filename' => 'pdf-to-png']);
        $request->request->add(['arguments' => ['-r300']]);
        $driver = (new ToolsManager($tool))->driver();
        if (method_exists($driver, 'setTask')) {
            $driver->setTask('pdfjpg');
        }
        $results = $driver->parse($request);

        if (!$results) {
            return redirect()->back()->withErrors(__('common.somethingWentWrong'));
        }

        return view('tools.pdf-png-converter', compact('tool', 'results'));
    }
}
