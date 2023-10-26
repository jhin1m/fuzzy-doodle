<?php

namespace App\Helpers;

use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SliderHelper
{
  /**
   * Upload and attach a slider image to a slidable entity.
   *
   * @param string $type The type of the slidable entity.
   * @param int $id The ID of the slidable entity.
   * @param \Illuminate\Http\Request $request The HTTP request containing the slider data.
   * @return void
   */
  public static function uploadAndAttachSlider($type, $id, $request)
  {
    $isActive = $request->slider_option == 1 ? 1 : 0;
    $sliderFile = $request->file("slider_cover");

    if ($sliderFile && settings()->get("image-encoding")) {
      $extension = settings()->get("extension") == "same" ? $sliderFile->getClientOriginalExtension() : settings()->get("extension");
      $slider_coverName = uniqid() . "." . $extension;

      $slider_coverImg = Image::make($sliderFile)->encode($extension, settings()->get("quality"));
      Storage::put("/public/slider/" . $slider_coverName, $slider_coverImg);
    } elseif ($sliderFile) {
      $slider_coverName = uniqid() . "." . $sliderFile->getClientOriginalExtension();
      $sliderFile->storeAs("public/slider", $slider_coverName);
    }

    if ($sliderFile || $isActive === 0 || $isActive === 1) {
      $oldSlider = Slider::where([["slidable_type", $type], ["slidable_id", $id]])->first();

      if ($oldSlider) {
        $oldSlider->is_active = $isActive;
        $oldSlider->image = $slider_coverName ?? $oldSlider->image;
        $oldSlider->save();
      } else {
        if ($sliderFile) {
          Slider::create([
            "slidable_type" => $type,
            "slidable_id" => $id,
            "image" => $slider_coverName,
            "is_active" => $isActive,
          ]);
        }
      }
    }
  }
}
