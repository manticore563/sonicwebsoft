<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Traits\ToolsPostAction;
use App\Components\ToolsManager;
use App\Contracts\ToolInterface;
use App\Traits\GhostscriptFields;

class ImageToPdf implements ToolInterface
{
    use GhostscriptFields, ToolsPostAction;

    /**
     * Is ImageMatic Extension installed
     *
     * @var boolean
     */
    private $mimes;
    private $mimesView;

    public function __construct()
    {
        $this->mimes = 'jpg,jpeg,png,gif,bmp,webp';
        $this->mimesView = '.jpg,.jpeg,.png,.gif,.bmp,.webp';
        if (extension_loaded('imagick')) {
            $this->mimes =  'jpg,jpeg,png,gif,tif,tiff,bmp,webp';
            $this->mimesView =  '.jpg,.jpeg,.png,.gif,.tif,.tiff,.bmp,.webp';
        }
    }


    public function render(Request $request, Tool $tool)
    {
        $mimes = $this->mimesView;

        return view('tools.image-to-pdf', compact('tool', 'mimes'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => "mimes:{$this->mimes}",
            'margin' => 'required',
            'page_orientation' => 'required',
            'page_size' => 'required',
            'merge_pages' => 'nullable',
        ]);

        $mimes = $this->mimesView;
        $request->request->add(['convert_to' => 'jpg']);
        $request->request->add(['output' => 'pdf']);
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

        return view('tools.image-to-pdf', compact('tool', 'mimes', 'results'));
    }
}
