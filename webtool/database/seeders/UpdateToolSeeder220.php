<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Database\Seeder;

class UpdateToolSeeder220 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->seedTools();
    }

    protected function seedTools()
    {
        $wc_tool_value_auth = 100;
        $wc_tool_value_guest = 50;
        $du_tool_value_auth = 10;
        $du_tool_value_guest = 5;
        $fs_tool_value_auth = 5;
        $fs_tool_value_guest = 1;
        $no_file_tool_value_auth = 2;
        $no_file_tool_value_guest = 1;
        $no_domain_tool_value_auth = 2;
        $no_domain_tool_value_guest = 1;
        $categories = [];
        foreach ($categories as $item) {
            $category = Category::tool()->slug($item['slug'])->firstOr(
                function () {
                    return Category::make();
                }
            );
            $category->fill($item);
            $category->save();
        }

        $tools = [
            [
                'category' => 'text-analysis-tools',
                'tools' => [
                    [
                        'display' => 99,
                        'slug' => "comma-separator",
                        'class_name' => 'App\Tools\CommaSeparator',
                        'icon_type' => 'class',
                        'icon_class' => 'spell-checker',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Comma Separator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'website-tracking-tools',
                'tools' => [
                    [
                        'display' => 99,
                        'slug' => "websites-broken-link-checker",
                        'class_name' => 'App\Tools\BrokenLinksChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'spider',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Websites Broken Link Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
        ];

        foreach ($tools as $data) {
            $category = Category::slug($data['category'])->first();
            if (!$category) {
                continue;
            }

            foreach ($data['tools'] as $item) {
                $tool = Tool::where('class_name', $item['class_name'])->firstOr(function () use ($category, $item) {
                    $tool = $category->tools()->make([]);

                    $tool->fill($item);
                    $tool->save();
                    $tool->category()->sync($category);
                });
            }
        }
    }

    function __destruct()
    {
        unlink(__FILE__);
    }
}
