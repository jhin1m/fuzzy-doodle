<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use App\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  /**
   * Validate and create a newly registered user.
   *
   * @param  array<string, string>  $input
   */
  public function create(array $input): User
  {
    Validator::make($input, [
      // 'name' => ['required', 'string', 'max:255'],
      "username" => ["required", "string", "alpha_dash", "min:4", "max:20", Rule::unique(User::class)],
      "email" => ["required", "string", "email:rfc,dns", "max:255", Rule::unique(User::class)],
      "password" => $this->passwordRules(),
    ])->validate();

    $user = User::create([
      // 'name' => $input['name'],
      "username" => $input["username"],
      "email" => $input["email"],
      "password" => Hash::make($input["password"]),
    ]);

    // Assign the default role to the user
    $defaultRole = Role::where("name", "user")->first();
    $user->assignRole($defaultRole);

    return $user;
  }
}
