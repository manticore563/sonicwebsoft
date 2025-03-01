<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Database\Seeder;

class UpdateToolSeeder extends Seeder
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
        $categories = [
            [
                'type' => 'tool',
                'status' => true,
                'order' => 1,
                'name' => 'Online PDF Tools',
                'title' => 'Online PDF Tools',
                'slug' => 'online-pdf-tools',
                'description' => 'Easily access a comprehensive set of PDF tools right at your fingertips. With just a few clicks, you can effortlessly merge, rotate, unlock, lock, watermark, and convert PDF files using these convenient features.',
            ],
            [
                'type' => 'tool',
                'status' => true,
                'order' => 1,
                'name' => 'Keywords Tools',
                'title' => 'Keywords Tools',
                'slug' => 'keywords-tool',
                'description' => 'Webmasters and SEO professionals can take advantage of these free, potent, and efficient keyword tools, offering thorough keyword research and analysis capabilities.',
            ],
            [
                'type' => 'tool',
                'status' => true,
                'order' => 1,
                'name' => 'Website Tracking Tools',
                'title' => 'Website Tracking Tools',
                'slug' => 'website-tracking-tools',
                'description' => 'Access a centralized compilation of free tools designed to measure, monitor, and track your website\'s performance seamlessly.',
            ],
        ];
        foreach ($categories as $item) {
            $category = Category::tool()->slug($item['slug'])->firstOr(function () {
                return Category::make();
            });
            $category->fill($item);
            $category->save();
        }

        $tools = [
            [
                'category' => 'online-pdf-tools',
                'tools' => [
                    [
                        'display' => 14,
                        'slug' => "word-pdf-converter",
                        'class_name' => 'App\Tools\WordToPdfConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'word-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Word To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "text-pdf-converter",
                        'class_name' => 'App\Tools\TextToPdfConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'text-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Text To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "merge-pdf",
                        'class_name' => 'App\Tools\MergePdf',
                        'icon_type' => 'class',
                        'icon_class' => 'merge-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Merge PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "organize-pdf",
                        'class_name' => 'App\Tools\OrganizePdf',
                        'icon_type' => 'class',
                        'icon_class' => 'organize-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Organize PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-zip",
                        'class_name' => 'App\Tools\PdfToZip',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-zip-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to ZIP', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "watermark-pdf",
                        'class_name' => 'App\Tools\WatermarkPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'protect-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Watermark PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "lock-pdf",
                        'class_name' => 'App\Tools\LockPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'protect-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Lock PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "unlock-pdf",
                        'class_name' => 'App\Tools\UnlockPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'unlock-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Unlock PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "jpg-to-pdf",
                        'class_name' => 'App\Tools\JpgToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'jpg-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'JPG To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "png-to-pdf",
                        'class_name' => 'App\Tools\PngToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'png-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PNG To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "gif-to-pdf",
                        'class_name' => 'App\Tools\GifToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'organize-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'GIF To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "bmp-to-pdf",
                        'class_name' => 'App\Tools\BmpToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'bmp-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'BMP To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "tiff-to-pdf",
                        'class_name' => 'App\Tools\TiffToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'tiff-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'TIFF To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "image-to-pdf",
                        'class_name' => 'App\Tools\ImageToPdf',
                        'icon_type' => 'class',
                        'icon_class' => 'jpg-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Image To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "html-to-pdf",
                        'class_name' => 'App\Tools\HtmlToPdfConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'organize-pdf-tool',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'HTML To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "ppt-to-pdf",
                        'class_name' => 'App\Tools\PptToPdfConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'power-point-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PPT To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "excel-to-pdf",
                        'class_name' => 'App\Tools\ExcelToPdfConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'excel-to-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Excel To PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-word",
                        'class_name' => 'App\Tools\PdfWordConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-word-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to Word', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-powerpoint",
                        'class_name' => 'App\Tools\PdfToPpt',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-power-point-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to PPT', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-excel",
                        'class_name' => 'App\Tools\PdfToExcelConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'organize-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to Excel', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-png",
                        'class_name' => 'App\Tools\PdfToPngConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-png-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to PNG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-jpg",
                        'class_name' => 'App\Tools\PdfToJpgConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-jpg-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to JPG', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-to-tiff",
                        'class_name' => 'App\Tools\PdfToTiffConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-tiff-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to TIFF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],

                    [
                        'display' => 14,
                        'slug' => "pdf-to-bmp",
                        'class_name' => 'App\Tools\PdfToBmpConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'pdf-to-bmp-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF to BMP', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "grayscale-pdf",
                        'class_name' => 'App\Tools\PdfGrayscale',
                        'icon_type' => 'class',
                        'icon_class' => 'grayscale-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'Grayscale PDF', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "pdf-compressor",
                        'class_name' => 'App\Tools\PdfCompressor',
                        'icon_type' => 'class',
                        'icon_class' => 'compress-pdf-tool',
                        'properties' => ["properties" => ["fs-tool", "du-tool", "no-file-tool"], "auth" => ["fs-tool" => $fs_tool_value_auth, "du-tool" => $du_tool_value_auth, "no-file-tool" => $no_file_tool_value_auth], "guest" => ["fs-tool" => $fs_tool_value_guest, "du-tool" => $du_tool_value_guest, "no-file-tool" => $no_file_tool_value_guest]],
                        'en' => ['name' => 'PDF Compressor', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "remove-pdf-pages",
                        'class_name' => 'App\Tools\PdfRemovePages',
                        'icon_type' => 'class',
                        'icon_class' => 'remove-pages-tool',
                        'properties' => ["properties" => ["du-tool", "fs-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "fs-tool" => $fs_tool_value_auth, "guest" => ["du-tool" => $du_tool_value_guest, "fs-tool" => $fs_tool_value_guest]],
                        'en' => ['name' => 'Remove PDF Pages', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'keywords-tool',
                'tools' => [
                    [
                        'display' => 14,
                        'slug' => "serp-checker",
                        'class_name' => 'App\Tools\SerpChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'serp-checker',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'SERP Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "keyword-position",
                        'class_name' => 'App\Tools\KeywordPosition',
                        'icon_type' => 'class',
                        'icon_class' => 'xml-formatter',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Keyword Position', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "keyword-density-checker",
                        'class_name' => 'App\Tools\KeyWordDensityChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'keyword-density-checker',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Keyword Density Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "related-keywords-finder",
                        'class_name' => 'App\Tools\RelatedKeywordsFinder',
                        'icon_type' => 'class',
                        'icon_class' => 'related-keywords-finder',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Related Keywords Finder', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "keyword-research-tool",
                        'class_name' => 'App\Tools\KeywordResearchTool',
                        'icon_type' => 'class',
                        'icon_class' => 'website-tracking-tools',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Keyword Research Tool', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "keywords-rich-domains",
                        'class_name' => 'App\Tools\KeywordsRichDomainsSuggestionsTool',
                        'icon_type' => 'class',
                        'icon_class' => 'browser',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Keywords Rich Domains', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'website-tracking-tools',
                'tools' => [
                    [
                        'display' => 14,
                        'slug' => "mozrank-checker",
                        'class_name' => 'App\Tools\MozRankChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'analytics',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Mozrank Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "google-cache-checker",
                        'class_name' => 'App\Tools\GoogleCacheChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'broom',
                        'properties' => ["properties" => ["du-tool", "no-domain-tool"], "auth" => ["no-domain-tool" => $no_domain_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest, "no-domain-tool" => $no_domain_tool_value_guest,]],
                        'en' => ['name' => 'Google Cache Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "check-gzip-compression",
                        'class_name' => 'App\Tools\CheckGzipCompression',
                        'icon_type' => 'class',
                        'icon_class' => 'zip',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Check GZIP Compression', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "ssl-checker",
                        'class_name' => 'App\Tools\SslChecker',
                        'icon_type' => 'class',
                        'icon_class' => 'lock',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'SSL Checker', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "spider-simulator",
                        'class_name' => 'App\Tools\SpiderSimulator',
                        'icon_type' => 'class',
                        'icon_class' => 'spider',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Spider Simulator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "what-is-my-browser",
                        'class_name' => 'App\Tools\WhatIsMyBrowser',
                        'icon_type' => 'class',
                        'icon_class' => 'browser',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'What is My Browser', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ],
            [
                'category' => 'website-management-tools',
                'tools' => [
                    [
                        'display' => 14,
                        'slug' => "get-http-headers",
                        'class_name' => 'App\Tools\GetHttpHeaders',
                        'icon_type' => 'class',
                        'icon_class' => 'code-pull',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Get HTTP Header', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],

                    [
                        'display' => 14,
                        'slug' => "htaccess-redirect",
                        'class_name' => 'App\Tools\HtaccessRedirect',
                        'icon_type' => 'class',
                        'icon_class' => 'code',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Htaccess Redirect', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "mobile-friendly-test",
                        'class_name' => 'App\Tools\MobileFriendlyTest',
                        'icon_type' => 'class',
                        'icon_class' => 'json-viewer',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Mobile Friendly Test', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "adsense-calculator",
                        'class_name' => 'App\Tools\AdsenseCalculator',
                        'icon_type' => 'class',
                        'icon_class' => 'sales-tax-calculator',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Adsense Calculator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "webpage-screen-resultion-simulator",
                        'class_name' => 'App\Tools\WebpageSimulator',
                        'icon_type' => 'class',
                        'icon_class' => 'website-screenshot',
                        'properties' => ["properties" => ["du-tool"], "auth" => ["du-tool" => $du_tool_value_auth], "guest" => ["du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Screen Resolution Simulator', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ],
            ],
            [
                'category' => 'text-analysis-tools',
                'tools' => [
                    [
                        'display' => 14,
                        'slug' => "english-converter",
                        'class_name' => 'App\Tools\EnglishConverter',
                        'icon_type' => 'class',
                        'icon_class' => 'translate-english',
                        'properties' => ["properties" => ["wc-tool", "du-tool"], "auth" => ["wc-tool" => $wc_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["wc-tool" => $wc_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'English Converter', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                    [
                        'display' => 14,
                        'slug' => "paraphrased",
                        'class_name' => 'App\Tools\Paraphrased',
                        'icon_type' => 'class',
                        'icon_class' => 'paraphrased',
                        'properties' => ["properties" => ["wc-tool", "du-tool"], "auth" => ["wc-tool" => $wc_tool_value_auth, "du-tool" => $du_tool_value_auth], "guest" => ["wc-tool" => $wc_tool_value_guest, "du-tool" => $du_tool_value_guest]],
                        'en' => ['name' => 'Paraphrased', 'description' => 'Edit me from admin panel...', 'content' => 'Edit me from admin panel...']
                    ],
                ]
            ]
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

                    return $tool;
                });
            }
        }
    }

    function __destruct()
    {
        unlink(__FILE__);
    }
}
