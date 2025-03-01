<?php

namespace App\Tools;

use App\Models\Tool;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class FakeNameGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.fake-name-generator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        // Validate the request with all locales
        $request->validate([
            'country' => 'required|in:ar_SA,hy_AM,az_AZ,zh_CN,zh_TW,hr_HR,cs_CZ,nl_NL,nl_BE,en_US,en_GB,en_AU,en_CA,en_IE,en_ZA,fi_FI,fr_FR,fr_CA,fr_CH,ka_GE,de_DE,de_AT,de_CH,id_ID,it_IT,ja_JP,ko_KR,ne_NP,nb_NO,fa_IR,pl_PL,pt_BR,pt_PT,ro_RO,ru_RU,sk_SK,es_ES,es_MX,sv_SE,tr_TR,uk_UA,vi_VN',
            'gender' => 'required|in:male,female,any',
            'number_of_names' => 'required|integer|min:1',
        ]);

        // Get the selected locale directly from the form input
        $country = $request->input('country');
        $gender = $request->input('gender');
        $number_of_names = $request->input('number_of_names');

        // Create Faker instance based on the selected locale
        $faker = Faker::create($country);

        // Initialize the names array
        $names = [];

        // Generate names based on the gender and number of names
        for ($i = 0; $i < $number_of_names; $i++) {
            // Handle gender-specific name generation
            if ($gender === 'male') {
                $names[] = $faker->firstNameMale . ' ' . $faker->lastName;
            } elseif ($gender === 'female') {
                $names[] = $faker->firstNameFemale . ' ' . $faker->lastName;
            } else {
                // Randomly pick between male and female names when 'any' is selected
                $firstName = rand(0, 1) ? $faker->firstNameMale : $faker->firstNameFemale;
                $names[] = $firstName . ' ' . $faker->lastName;
            }
        }

        $results = [
            'names' => $names,
        ];

        return view('tools.fake-name-generator', compact('results', 'tool', 'country', 'gender', 'number_of_names'));
    }
}
