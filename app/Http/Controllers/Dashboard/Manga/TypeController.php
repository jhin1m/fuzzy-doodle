<?php

namespace App\Http\Controllers\Dashboard\Manga;

use App\Models\Manga;
use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TypeController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Retrieve a list of manga types.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $typesQuery = Taxonomy::query()->where("type", "type");

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $typesQuery->where("title", "LIKE", "%$title%");
    }

    $types = $typesQuery->latest()->fastPaginate(20);
    return view("dashboard.mangas.types.index", compact("types"));
  }

  /**
   * Create a new type.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.mangas.types.create");
  }

  /**
   * Store a new type.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $typeData = $request->validate([
      "title" => ["required"],
    ]);

    $typeData["slug"] = Str::slug($typeData["title"], "-");
    $typeData["type"] = "type";
    Taxonomy::create($typeData);
    Cache::flush();

    return redirect(route("dashboard.mangas_types.index"))->with("success", __("Type has been created!"));
  }

  /**
   * Edit a type.
   *
   * @param  $id
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
    $type = Taxonomy::where("type", "type")->findOrFail($id);
    return view("dashboard.mangas.types.edit", compact("type"));
  }

  /**
   * Update the specified type.
   *
   * @param  $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update($id, Request $request)
  {
    $type = Taxonomy::where("type", "type")->findOrFail($id);

    $typeData = $request->validate([
      "title" => ["required"],
      "slug" => ["required", "alpha_dash", Rule::unique(Taxonomy::class, "slug")->ignore($type)],
    ]);

    $typeData["slug"] = strtolower($typeData["slug"]);

    $type->update($typeData);
    Cache::flush();

    return back()->with("success", __("Type has been updated!"));
  }

  /**
   * Delete the specified type.
   *
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete($id)
  {
    $type = Taxonomy::where("type", "type")->findOrFail($id);
    $type
      ->taxables()
      ->where("taxable_type", Manga::class)
      ->detach();

    $type->delete();
    Cache::flush();

    return back()->with("success", __("Type has been deleted."));
  }
}
