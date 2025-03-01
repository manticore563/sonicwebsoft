<?php

namespace App\Http\Controllers\Admin;

use File;
use Theme;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Igaster\LaravelTheme\themeManifest;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class ThemesController extends Controller
{
    protected $tempPath;

    /**
     * Create a new route command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tempPath = $this->packages_path('tmp');
        Theme::set('admin');
    }

    /**
     * Display all available themes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = false)
    {
        $themes = $this->get_front_themes();

        return view('themes.manage', compact('themes'));
    }

    /**
     * Display all available themes.
     *
     * @return \Illuminate\Http\Response
     */
    public function activate($name)
    {
        if (!$theme = $this->find_theme($name)) {
            return redirect()->route('admin.themes.manage')->withError(__('admin.themeNotFound'));
        }

        if (empty($theme->settings['require']) || empty($theme->settings['require'])) {
            return redirect()->route('admin.themes.manage')->withError(__('admin.invalidTheme'));
        }

        if (!version_compare(config('artisan.version'), $theme->settings['require'], '>=')) {
            return redirect()->route('admin.themes.manage')->withError(__('admin.themeRequirementError', ['theme' => $theme->name, 'version' => $theme->settings['require']]));
        }

        $this->set_theme($theme->name);
        $this->optimize();

        sleep(2);
        return redirect()->back()->withSuccess(__('admin.themeActivated'));
    }

    /**
     * Upload file and install theme
     *
     * @return \Illuminate\Http\Response
     */
    protected function install(Request $request)
    {
        $validator = $this->validate($request, ['theme' => 'required|mimes:zip']);

        // Check if valid Zip file
        $is_valid = \Zip::check($request->file('theme'));
        if (!$is_valid) {
            return redirect()->back()->withErrors(__('admin.invalidZipFile'));
        }

        // Check if zip has the theme.json file
        $zip = \Zip::open($request->file('theme'));
        if (!$zip->has('views/theme.json')) {
            return redirect()->back()->withErrors(__('Invalid theme package.'));
        }

        // Read theme.json & check if theme is front theme.
        $zip->extract($this->tempPath, 'views/theme.json');
        $themeJson = new themeManifest();
        $themeJson->loadFromFile($this->tempPath . "/views/theme.json");

        $defaults = $themeJson->get('defaults', false);
        if (!in_array($themeJson->get('category', false), array('front', 'admin'))) {
            return redirect()->back()->withErrors(__('This is not a valid package for MonsterTools, please contact theme author for support.'));
        }

        // Check theme required attriibutes
        if (
            !$themeJson->get('version', false)
            || !$themeJson->get('require', false)
            || !$themeJson->get('title', false)
            || !$themeJson->get('screenshot', false)
            || !isset($defaults['body_font_family'])
            || !isset($defaults['heading_font_family'])
            || !isset($defaults['body_font_variant'])
            || !isset($defaults['heading_font_variant'])
        ) {
            return redirect()->back()->withErrors(__("Required theme information is missing in theme.json file."));
        }

        // Check required version
        if (!version_compare(config('artisan.version'), $themeJson->get('require', false), '>=')) {
            return redirect()->back()->withError(__('admin.themeRequirementError', ['theme' => $themeJson->get('name', false), 'version' => $themeJson->get('require', false)]));
        }

        // Check if theme is already installed
        $themeName = $themeJson->get('name');
        if ($this->theme_installed($themeName)) {
            $theme = new themeManifest();
            $viewsPath = Theme::find($themeName)->viewsPath;
            $pathTheme = themes_path($viewsPath . DIRECTORY_SEPARATOR . 'theme.json');
            $theme->loadFromFile($pathTheme);

            if ($theme->get('version') == $themeJson->get('version')) {
                $this->clearTempFolder();

                return redirect()->back()->withErrors(__('Theme "' . $themeName . '" v' . $themeJson->get('version') . ' is already installed.'));
            }

            $this->removeTheme($themeName);
        }

        // Target Paths
        $themeViews = themes_path($themeJson->get('views-path'));
        $themeViews = Str::of($themeViews)->finish('/')->finish($themeName);
        $themeAssets = public_path($themeJson->get('asset-path'));

        File::copyDirectory("{$this->tempPath}/views", $themeViews);
        File::copyDirectory("{$this->tempPath}/assets", $themeAssets);

        // Rebuild Themes Cache
        Theme::rebuildCache();

        // Del Temp Folder
        $this->clearTempFolder();

        //sleep for theme cache rebuild.
        sleep(3);

        return redirect()->route('themes.manage')->withSuccess(__('Theme "' . $themeName . '" installed successfully.'));
    }

    public function onlineTheme()
    {
        // $link = 'https://verify.dotartisan.com/check';
        // $response = Http::post($link, ['version' => setting('version'), 'item'  => "monster-tools"]);
        // $data = $response;

        return view('themes.list');
    }

    /**
     * remove theme.
     *
     */
    protected function removeTheme($themeName)
    {
        $theme = Theme::find($themeName);
        // Delete folders
        $theme->uninstall();
    }

    /**
     * get theme packages path.
     *
     */
    protected function packages_path($path = '')
    {
        return storage_path('themes' . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * delete temp directory
     *
     */
    protected function clearTempFolder()
    {
        if (File::exists($this->tempPath)) {
            File::deleteDirectory($this->tempPath);
        }
    }

    /**
     * check if theme is installed.
     *
     * @return bool
     */
    protected function theme_installed($themeName)
    {
        if (!Theme::exists($themeName)) {
            return false;
        }
        $viewsPath = Theme::find($themeName)->viewsPath;
        $themeJson = themes_path($viewsPath . DIRECTORY_SEPARATOR . 'theme.json');

        return File::exists($themeJson);
    }

    /**
     * Get all front themes.
     *
     * @return \Illuminate\Http\Response
     */
    protected function set_theme($name)
    {
        $env = DotenvEditor::load();
        $env->setKey('FRONT_THEME', $name);
        $env->save();
    }

    private function optimize()
    {
        try {
            Artisan::call('optimize');

            return Artisan::output();
        } catch (\Exception $e) {
            // dd($e);
        }
    }

    /**
     * Get all front themes.
     *
     * @return \Illuminate\Http\Response
     */
    protected function find_theme($name)
    {
        $themes = Theme::all();

        foreach ($themes as $theme) {
            if ($theme->name === $name) {
                return $theme;
            }
        }

        return false;
    }

    /**
     * Get all front themes.
     *
     * @return \Illuminate\Http\Response
     */
    protected function get_front_themes($type = 'front')
    {
        $themes = Theme::all();

        return array_filter(
            $themes,
            function ($theme) use ($type) {
                return isset($theme->settings['category']) && $theme->settings['category'] === $type;
            }
        );
    }
}
