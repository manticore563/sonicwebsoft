<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Traits\ToolsPostAction;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Traits\LibreConvertAPIFields;

class PdfToPpt implements ToolInterface
{
    use LibreConvertAPIFields, ToolsPostAction;

    public function render(Request $request, Tool $tool)
    {
        return view('tools.pdf-powerpoint-converter', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'files' => "required|max:{$tool->no_file_tool}",
            'files.*' => "required|mimes:pdf|max:" . convert_mb_into_kb($tool->fs_tool)
        ]);

        $request->request->add(['format' => 'pptx']);
        $request->request->add(['filter' => 'Impress MS PowerPoint 2007 XML']);

        $driver = (new ToolsManager($tool))->driver();
        $result = $driver->parse($request);

        if (!$result['success']) {
            return redirect()->back()->withErrors($result['message']);
        }

        if (count($result['files']) == 0) {
            return redirect()->back()->withErrors(__('tools.countNotConvert'));
        }

        $results = [
            'files' => $result['files'],
            'process_id' => $result['process_id']
        ];

        return view('tools.pdf-powerpoint-converter', compact('results', 'tool'));
    }
}
