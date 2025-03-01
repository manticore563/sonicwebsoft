<?php

namespace App\Traits;

trait LibreConvertAPIFields
{
    public static function getFileds()
    {
        $array = [
            'title' => "Drivers",
            'fields' => [
                [
                    'id' => "driver",
                    'field' => "tool-options-select",
                    'placeholder' => "Driver",
                    'label' => "Driver",
                    'required' => true,
                    'options' => [['text' => "LibreOffice", 'value' => "LibreOffice"], ['text' => "Convert API", 'value' => "convertApi"]],
                    'validation' => "required",
                    'type' => 'dropdown',
                    'classes' => "",
                    'dependant' => null,
                ],
                [
                    'id' => "convert_api_secret",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Please enter ConverAPI Secret here....",
                    'label' => "API Secret",
                    'required' => false,
                    'options' => null,
                    'validation' => "required_if:driver,convertApi",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "convertApi"],
                ],
                [
                    'id' => "convert_api_key",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Please enter ConverAPI Key here....",
                    'label' => "API Key",
                    'required' => false,
                    'options' => null,
                    'validation' => "required_if:driver,convertApi",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "convertApi"],
                ],
                [
                    'id' => "libre_office_path",
                    'field' => "tool-options-textfield",
                    'placeholder' => "Please enter LibreOffice exe path here....",
                    'label' => "Binary Path (optional)",
                    'required' => false,
                    'options' => null,
                    'validation' => "nullable",
                    'type' => 'text',
                    'min' => null,
                    'max' => null,
                    'classes' => "",
                    'dependant' => ['settings[driver]', "LibreOffice"],
                ],
            ],
            "default" => ['driver' => 'LibreOffice', 'libre_office_path' => '']
        ];

        return $array;
    }
}
