<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Qirolab\Theme\Theme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ThemeController extends Controller
{
  /**
   * Show the theme settings page.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $themes = $this->getThemes();
    return view("dashboard.settings.theme", compact("themes"));
  }

  /**
   * Update the theme settings.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    $setting = $request->validate([
      "theme_active" => "required",
      "theme_mode" => "required|in:light,dark",
      "theme_slider" => "required|in:1,0",
      "facebook" => "nullable|url",
      "instagram" => "nullable|url",
      "twitter" => "nullable|url",
      "discord" => "nullable|url",
      "chapter_lazyload" => "required|in:1,0",
    ]);

    Theme::set($setting["theme_active"]);

    settings()->set("theme.active", $setting["theme_active"]);
    settings()->set("theme.mode", $setting["theme_mode"]);
    settings()->set("theme.slider", $setting["theme_slider"]);
    settings()->set("theme.social.facebook", $setting["facebook"]);
    settings()->set("theme.social.instagram", $setting["instagram"]);
    settings()->set("theme.social.twitter", $setting["twitter"]);
    settings()->set("theme.social.discord", $setting["discord"]);

    settings()->set("chapter.lazyload", $setting["chapter_lazyload"]);

    return back()->with("success", __("Theme settings have been updated"));
  }

  private function getThemes()
  {
    $themesPath = base_path("/themes");
    $themes = [];

    if (File::isDirectory($themesPath)) {
      $directories = File::directories($themesPath);

      foreach ($directories as $directory) {
        $themeName = basename($directory);
        $themes[] = $themeName;
      }
    }

    return $themes;
  }
}
