<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
  /**
   * Show the upload settings page.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view("dashboard.settings.upload");
  }

  /**
   * Update the upload settings.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    $setting = $request->validate([
      "image-encoding" => "required|in:0,1",
      "image-driver" => "required|in:gd,imagick",
      "extension" => "required|in:webp,jpg,jpeg,png,same",
      "quality" => "required|numeric|min:1|max:100",
    ]);

    settings()->set("image-encoding", $setting["image-encoding"]);
    settings()->set("image-driver", $setting["image-driver"]);
    settings()->set("extension", $setting["extension"]);
    settings()->set("quality", $setting["quality"]);

    return back()->with("success", __("Upload settings have been updated"));
  }
}
