<?php

namespace App\Http\Controllers\Dashboard\Ads;

use Exception;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the list of ads.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $adsQuery = Ad::query();

    if ($request->filled("filter")) {
      $name = $request->input("filter");

      $adsQuery->where("name", "LIKE", "%" . $name . "%");
    }

    $ads = $adsQuery->latest()->fastPaginate(20);

    return view("dashboard.ads.index", compact("ads"));
  }

  /**
   * Create a new ad.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.ads.create");
  }

  /**
   * Store a new ad.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Ad $ad, Request $request)
  {
    $adData = $request->validate([
      "name" => ["required"],
      "identifier" => ["required", "alpha_dash", Rule::unique(Ad::class, "identifier")],
      "type" => ["required", "in:banner,script"],
      "image" => [$request->input("type") === "banner" ? "required" : "nullable", "image"],
      "link" => [$request->input("type") === "banner" ? "required" : "nullable", "url"],
      "description" => ["nullable", "max:500"],
      "script" => [$request->input("type") === "script" ? "required" : "nullable", "max:3000"],
      "is_active" => ["required", "boolean"],
    ]);

    try {
      $adData["identifier"] = strtolower($adData["identifier"]);

      if ($request->hasFile("image")) {
        $adData["image"] = $request->file("image")->store("ads", ["disk" => "public"]);
      }

      $ad->create($adData);
    } catch (Exception $e) {
      return back()->with("error", $e->getMessage());
    }

    return redirect(route("dashboard.ads.index"))->with("success", __("Ad has been created"));
  }

  /**
   * Edit a ad.
   *
   * @param  \App\Models\Ad  $ad
   * @return \Illuminate\View\View
   */
  public function edit(Ad $ad)
  {
    return view("dashboard.ads.edit", compact("ad"));
  }

  /**
   * Update the specified ad.
   *
   * @param  \App\Models\Ad  $ad
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Ad $ad, Request $request)
  {
    $adData = $request->validate([
      "name" => ["required"],
      "identifier" => ["required", "alpha_dash", Rule::unique(Ad::class, "identifier")->ignore($ad, "identifier")],
      "type" => ["required", "in:banner,script"],
      "image" => ["nullable", "image"],
      "link" => [$request->input("type") === "banner" ? "required" : "nullable"],
      "description" => ["nullable", "max:500"],
      "script" => [$request->input("type") === "script" ? "required" : "nullable", "max:3000"],
      "is_active" => ["required", "boolean"],
    ]);

    try {
      $adData["identifier"] = strtolower($adData["identifier"]);

      if ($request->hasFile("image")) {
        $this->deleteImage($ad->image);
        $adData["image"] = $request->file("image")->store("ads", ["disk" => "public"]);
      }

      $ad->update($adData);
    } catch (Exception $e) {
      return back()->with("error", $e->getMessage());
    }

    return redirect(route("dashboard.ads.index"))->with("success", __("Ad has been updated"));
  }

  /**
   * Delete the specified ad.
   *
   * @param  \App\Models\Ad  $ad
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Ad $ad)
  {
    if ($ad->image) {
      $this->deleteImage($ad->image);
    }

    $ad->delete();

    return back()->with("success", __("Ad has been deleted"));
  }

  private function deleteImage($image)
  {
    if ($image) {
      Storage::disk("public")->delete($image);
    }
  }
}
