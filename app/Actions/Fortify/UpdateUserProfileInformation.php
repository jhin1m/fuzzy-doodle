<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
  /**
   * Validate and update the given user's profile information.
   *
   * @param  \App\Models\User  $user
   * @param  array  $input
   * @param  mixed  $avatar
   * @return void
   */
  public function update(User $user, array $input)
  {
    Validator::make($input, [
      // 'name' => ['required', 'string', 'max:255'],
      "username" => ["required", "string", "alpha_dash", "min:4", "max:20", Rule::unique(User::class)->ignore($user->id)],
      "email" => ["required", "string", "email:rfc,dns", "max:255", Rule::unique(User::class)->ignore($user->id)],
      "description" => ["nullable", "string", "max:255"],
      "avatar" => "nullable|image|max:2048",
    ])->validateWithBag("updateProfileInformation");

    $avatar = $input["avatar"] ?? null;
    if ($avatar !== null) {
      if ($user->avatar) {
        Storage::delete("public/avatars/" . $user->avatar);
      }

      $image = $avatar;
      $imageName = uniqid() . ".webp";
      $img = Image::make($image);
      $img->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });

      $imgData = $img->encode("webp", settings()->get("quality"));
      Storage::put("/public/avatars/" . $imageName, $imgData);

      $input["avatar"] = $imageName;
    } else {
      $input["avatar"] = $user->avatar;
    }

    if ($input["email"] !== $user->email && $user instanceof MustVerifyEmail) {
      $this->updateVerifiedUser($user, $input);
    } else {
      $user
        ->forceFill([
          // 'name' => $input['name'],
          "username" => $input["username"],
          "email" => $input["email"],
          "description" => $input["description"],
          "avatar" => $input["avatar"] ?? $user->avatar, // Use the existing avatar if not updated
        ])
        ->save();
    }
  }

  /**
   * Update the given verified user's profile information.
   *
   * @param  \App\Models\User  $user
   * @param  array  $input
   * @return void
   */
  protected function updateVerifiedUser(User $user, array $input): void
  {
    $user
      ->forceFill([
        // 'name' => $input['name'],
        "username" => $input["username"],
        "email" => $input["email"],
        "email_verified_at" => null,
        "description" => $input["description"],
      ])
      ->save();

    $user->sendEmailVerificationNotification();
  }
}
