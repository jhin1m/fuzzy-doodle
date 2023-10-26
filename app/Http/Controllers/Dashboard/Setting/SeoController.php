<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
  /**
   * Show the seo settings page.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view("dashboard.settings.seo");
  }

  /**
   * Update the seo settings.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    $setting = $request->validate([
      "manga-title" => "required",
      "manga-description" => "required",
      "chapter-title" => "required",
      "chapter-description" => "required",
      "mangas-title" => "required",
      "mangas-description" => "required",
    ]);

    settings()->set("seo.manga.title", $setting["manga-title"]);
    settings()->set("seo.manga.description", $setting["manga-description"]);
    settings()->set("seo.chapter.title", $setting["chapter-title"]);
    settings()->set("seo.chapter.description", $setting["chapter-description"]);
    settings()->set("seo.mangas.title", $setting["mangas-title"]);
    settings()->set("seo.mangas.description", $setting["mangas-description"]);

    return back()->with("success", __("SEO settings have been updated"));
  }
}
