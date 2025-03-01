<?php

namespace App\Tools;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MessageIDValidation;
use Egulias\EmailValidator\EmailValidator as ValidateEmail;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;

class EmailValidator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.email-validator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'emails' => 'required',
        ]);

        $emails = $request->input('emails');
        $results = [
            'emails' => $emails,
            'emailAddresses' => explode(PHP_EOL, $emails),
        ];

        return view('tools.email-validator', compact('results', 'tool'));
    }

    public function postAction(Request $request, $tool)
    {
        $validator = new ValidateEmail();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
            new MessageIDValidation(),
            new SpoofCheckValidation(),
        ], 0);

        return $validator->isValid($request->email, $multipleValidations) ? 'true' : 'false';
    }
}
