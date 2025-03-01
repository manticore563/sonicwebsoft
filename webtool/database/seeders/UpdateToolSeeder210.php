<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Database\Seeder;

class UpdateToolSeeder210 extends Seeder
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
            $category = Category::tool()->slug($item['slug'])->firstOr(function () {
                return Category::make();
            });
            $category->fill($item);
            $category->save();
        }

        $tools = [
            [
                'category' => 'website-management-tools',
                'tools' => [
                    [
                        'display' => 99,
                        'slug' => "email-validator",
                        'class_name' => 'App\Tools\EmailValidator',
                        'icon_type' => 'class',
                        'icon_class' => 'spell-checker',
                        'properties' => ["properties" => ["no-domain-tool", "du-tool"], "auth" => ["no-domain-tool" => $no_domain_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["no-domain-tool" => $no_domain_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Bulk Email Validator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'text-analysis-tools',
                'tools' => [
                    [
                        'display' => 99,
                        'slug' => "word-counter",
                        'class_name' => 'App\Tools\WordCounter',
                        'icon_type' => 'class',
                        'icon_class' => 'word-counter',
                        'properties' => ["properties" => ["wc-tool", "du-tool"], "auth" => ["wc-tool" => $wc_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["wc-tool" => $wc_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Word Counter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'image-tools',
                'tools' => [
                    [
                        'display' => 9,
                        'slug' => "webp-to-png",
                        'class_name' => 'App\Tools\WebpToPngConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'image-editor',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'WEBP to PNG Converter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 10,
                        'slug' => "png-to-webp",
                        'class_name' => 'App\Tools\PngToWebp',
                        'icon_type' => 'class',
                        'icon_class' => 'img-text',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PNG to WEBP Converter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'online-calculators',
                'tools' => [
                    [
                        'display' => 9,
                        'slug' => "number-generator",
                        'class_name' => 'App\Tools\RandomNumberGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'word-counter',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Random Number Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'development-tools',
                'tools' => [
                    [
                        'display' => 9,
                        'slug' => "uuid-generator",
                        'class_name' => 'App\Tools\UuidGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'word-counter',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'UUID Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 9,
                        'slug' => "lorem-ipsum-generator",
                        'class_name' => 'App\Tools\LoremIpsumGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'word-counter',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Lorem Ipsum Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
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
