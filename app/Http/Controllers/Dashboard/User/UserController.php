<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
// use Intervention\Image\Facades\Image;
// use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the list of users.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $usersQuery = User::query();

    if ($request->filled("filter")) {
      $username = $request->input("filter");
      $usersQuery->where("username", "LIKE", "%$username%");
    }

    $users = $usersQuery->latest()->fastPaginate(20);
    return view("dashboard.users.index", compact("users"));
  }

  /**
   * Create a new user.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.users.create");
  }

  /**
   * Store a new user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $userData = $request->validate([
      "username" => ["required", "min:4", "max:20", "unique:users,username"],
      "email" => ["required", "email", "unique:users,email"],
      "password" => ["required", "confirmed", "min:8"],
      "description" => ["nullable", "string", "max:255"],
      "roles" => ["required", "array"],
      "roles.*" => ["exists:roles,name"],
    ]);

    $user = User::create([
      "username" => $userData["username"],
      "email" => $userData["email"],
      "password" => Hash::make($userData["password"]),
      "description" => $userData["description"],
    ]);

    $roles = Role::whereIn("name", $userData["roles"])->get();
    $user->assignRole($roles);

    return redirect()
      ->route("dashboard.users.index")
      ->with("success", __("User has been created"));
  }

  /**
   * Edit a user.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\View\View
   */
  public function edit(User $user)
  {
    return view("dashboard.users.edit", ["user" => $user]);
  }

  /**
   * Update the specified user.
   *
   * @param  \App\Models\User  $user
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(User $user, Request $request)
  {
    $userData = $request->validate([
      "username" => ["required", "min:4", "max:20", Rule::unique("users", "username")->ignore($user->id, "id")],
      "email" => ["required", "email", Rule::unique("users", "email")->ignore($user->id, "id")],
      "password" => ["nullable", "confirmed", "min:8"],
      "description" => ["nullable", "string", "max:255"],
      "roles" => ["required", "array"],
      "roles.*" => ["exists:roles,name"],
    ]);

    if ($request->filled("password")) {
      $userData["password"] = bcrypt($request->input("password"));
    } else {
      unset($userData["password"]);
    }

    $user->update($userData);

    $roles = Role::whereIn("name", $userData["roles"])->get();
    $user->syncRoles($roles);

    return back()->with("success", __("User has been updated"));
  }

  /**
   * Delete the specified user.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(User $user)
  {
    if (auth()->user()->id == $user->id) {
      return back()->with("error", __("You cannot delete yourself"));
    }

    if ($user->hasRole("super admin")) {
      return back()->with("error", __("You cannot delete an super admin"));
    }

    $user->delete();

    return back()->with("success", __("User has been deleted"));
  }

  /**
   * Retrieve a list of deleted users.
   *
   * @return \Illuminate\View\View
   */
  public function deleted(Request $request)
  {
    $usersQuery = User::onlyTrashed();

    if ($request->filled("filter")) {
      $username = $request->input("filter");
      $usersQuery->where("values->username", "LIKE", "%$username%");
    }

    $users = $usersQuery->latest()->fastPaginate(20);

    return view("dashboard.users.deleted", compact("users"));
  }

  /**
   * Restore a deleted user.
   *
   * @param  int  $id  The ID of the manga to restore.
   * @return \Illuminate\Http\RedirectResponse
   */
  public function restore($id)
  {
    $user = User::withTrashed()->findOrFail($id);
    $user->restore();

    return back()->with("success", __("User has been restored"));
  }

  /**
   * Permanently delete a user.
   *
   * @param  int|string  $id  The ID or key of the manga to be permanently deleted.
   * @return \Illuminate\Http\RedirectResponse
   */
  public function hard_delete($id)
  {
    $user = User::withTrashed()->findOrFail($id);
    $user->forceDelete();

    return back()->with("success", __("User has been permanently deleted"));
  }
}
