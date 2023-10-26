<?php

namespace App\Http\Controllers\Dashboard\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the list of Roles.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $rolesQuery = Role::query();
    if ($request->filled("filter")) {
      $name = $request->input("filter");

      $rolesQuery->where("name", "LIKE", "%" . $name . "%");
    }

    $roles = $rolesQuery->latest("id")->fastPaginate(20);
    return view("dashboard.roles.index", compact("roles"));
  }

  /**
   * Create a new role.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.roles.create");
  }

  /**
   * Store a new role.
   *
   * @param  \App\Models\Role  $role
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Role $role, Request $request)
  {
    $request->validate([
      "name" => ["required", "string", "max:255", Rule::unique(Role::class)],
      "permissions" => ["nullable", "array"],
    ]);

    $role = Role::create(["name" => $request->name, "guard_name" => "web"]);

    if (isset($request->permissions)) {
      $permissions = Permission::whereIn("id", $request->permissions)->pluck("name");
      $role->syncPermissions($permissions);
    }

    return redirect()
      ->route("dashboard.roles.index")
      ->with("success", __("Role created successfully"));
  }

  /**
   * Edit a role.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\View\View
   */
  public function edit(Role $role)
  {
    return view("dashboard.roles.edit", compact("role"));
  }

  /**
   * Update the specified role.
   *
   * @param  \App\Models\Role  $role
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Role $role, Request $request)
  {
    $request->validate([
      "name" => ["required", Rule::unique("roles")->ignore($role)],
      "permissions" => ["nullable", "array"],
    ]);

    $role->update(["name" => $request->name]);

    if (isset($request->permissions)) {
      $permissions = Permission::whereIn("id", $request->permissions)->pluck("name");
      $role->syncPermissions($permissions);
    }

    return back()->with("success", __("Role has been updated"));
  }

  /**
   * Delete the specified role.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Role $role)
  {
    if ($role->name === "super admin") {
      return back()->with("error", __("You cannot delete this role"));
    }

    $role->delete();

    return back()->with("success", __("Role has been deleted"));
  }
}
