<?php

namespace App\Providers;

use Qirolab\Theme\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ThemeConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $selectedTheme = Theme::active();
        if ($selectedTheme) {
            $themeConfigPath = config('theme.base_path') . '/' . $selectedTheme . '/theme.php';

            if (file_exists($themeConfigPath)) {
                $themeConfig = require $themeConfigPath;
                Config::set('theme', array_merge(Config::get('theme'), $themeConfig));
            }
        }
    }
}
