<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedTools();
    }

    protected function seedTools()
    {
        $du_tool_value_auth = 10;
        $du_tool_value_guest = 5;
        $fs_tool_value_auth = 5;
        $fs_tool_value_guest = 1;
        $no_file_tool_value_auth = 2;
        $no_file_tool_value_guest = 1;

        $no_domain_tool_value_auth = 2;
        $no_domain_tool_value_guest = 1;
        $wc_tool_value_auth = 100;
        $wc_tool_value_guest = 50;

        $categories = [
            [
                'type' => 'tool',
                'status' => true,
                'order' => 1,
                'name' => 'Other Tools',
                'title' => 'Other Tools',
                'slug' => 'other-tools',
                'description' => 'Explore the \'Other Tools\' for solutions to everyday problems and challenges.',
            ],
        ];
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
                'category' => 'image-tools',
                'tools' => [
                    [
                        'display' => 99,
                        'slug' => "video-to-gif",
                        'class_name' => 'App\Tools\VideoToGif',
                        'icon_type' => 'class',
                        'icon_class' => 'image-editor',
                        'properties' => ["properties" => ["fs-tool", "du-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Video to GIF Converter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "svg-converter",
                        'class_name' => 'App\Tools\SvgConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'image-editor',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'SVG Converter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "png-to-svg",
                        'class_name' => 'App\Tools\PngToSvg',
                        'icon_type' => 'class',
                        'icon_class' => 'image-editor',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PNG to SVG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "jpg-to-svg",
                        'class_name' => 'App\Tools\JpgToSvg',
                        'icon_type' => 'class',
                        'icon_class' => 'image-editor',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'JPG to SVG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "heic-to-jpg",
                        'class_name' => 'App\Tools\HeicToJpg',
                        'icon_type' => 'class',
                        'icon_class' => 'convert-jpg',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'HEIC to JPG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "heic-to-png",
                        'class_name' => 'App\Tools\HeicToPng',
                        'icon_type' => 'class',
                        'icon_class' => 'online-png',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'HEIC to PNG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "avif-to-jpg",
                        'class_name' => 'App\Tools\AvifToJpg',
                        'icon_type' => 'class',
                        'icon_class' => 'convert-jpg',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'AVIF to JPG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "avif-to-png",
                        'class_name' => 'App\Tools\AvifToPng',
                        'icon_type' => 'class',
                        'icon_class' => 'online-png',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'AVIF to PNG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "svg-to-jpg",
                        'class_name' => 'App\Tools\SvgToJpg',
                        'icon_type' => 'class',
                        'icon_class' => 'convert-jpg',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'SVG to JPG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 99,
                        'slug' => "svg-to-png",
                        'class_name' => 'App\Tools\SvgToPng',
                        'icon_type' => 'class',
                        'icon_class' => 'online-png',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'SVG to PNG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'other-tools',
                'tools' => [
                    [
                        'display' => 1,
                        'slug' => "credit-card-generator",
                        'class_name' => 'App\Tools\CreditCardGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'probability-calculator',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Credit Card Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 1,
                        'slug' => "fake-address-generator",
                        'class_name' => 'App\Tools\FakeAddressGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'reverse-text-generator',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Fake Address Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 1,
                        'slug' => "fake-name-generator",
                        'class_name' => 'App\Tools\FakeNameGenerator',
                        'icon_type' => 'class',
                        'icon_class' => 'reverse-text-generator',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Fake Name Generator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
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
