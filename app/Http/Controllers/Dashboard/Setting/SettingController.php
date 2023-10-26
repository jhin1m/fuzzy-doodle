<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
  /**
   * Show the site settings page.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view("dashboard.settings.site");
  }

  /**
   * Update the site settings.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    $setting = $request->validate([
      "name" => "required",
      "url" => "required|url",
      "https-force" => "required|in:0,1",
      "description" => "nullable",
      "keywords" => "nullable",
      "logo" => "nullable|image",
      "favicon" => "nullable|image",
      "auth-cover" => "nullable|image",
      "custom_html" => "nullable",
      // "locale" => "required|in:en,ar",
      "locale" => "required",
    ]);

    // return $setting;

    settings()->set("name", $setting["name"]);
    settings()->set("url", $setting["url"]);
    settings()->set("https-force", $setting["https-force"]);
    settings()->set("description", $setting["description"]);
    settings()->set("keywords", $setting["keywords"]);
    settings()->set("custom_html", $setting["custom_html"]);
    settings()->set("locale", $setting["locale"]);

    $this->handleFileUpload($request, "logo", $setting);
    $this->handleFileUpload($request, "favicon", $setting);
    $this->handleFileUpload($request, "auth-cover", $setting);

    return back()->with("success", __("Settings have been updated"));
  }

  /**
   * Clear the cache.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function clear_cache()
  {
    Cache::flush();
    Artisan::call("view:clear");
    Artisan::call("config:clear");
    // Artisan::call("route:clear");
    return back()->with("success", __("Cache has been cleared"));
  }

  /**
   * Handle file upload for a specific field.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $fieldName
   * @param  array  $setting
   * @return void
   */
  private function handleFileUpload(Request $request, $fieldName, &$setting)
  {
    if ($request->hasFile($fieldName)) {
      $file = $request->file($fieldName);
      $fileName = $fieldName . "." . $file->getClientOriginalExtension();
      $this->deleteExistingFile(settings()->get($fieldName));
      settings()->set($fieldName, $this->uploadFile($file, $fileName));
    }
  }

  /**
   * Delete the existing file.
   *
   * @param  string|null  $file
   * @return void
   */
  private function deleteExistingFile($file)
  {
    if (!empty($file)) {
      Storage::delete("public/site/" . $file);
    }
  }

  /**
   * Upload a file.
   *
   * @param  \Illuminate\Http\UploadedFile  $file
   * @param  string  $fileName
   * @return string
   */
  private function uploadFile($file, $fileName)
  {
    return $file->storePubliclyAs("public/site", $fileName);
  }
}
