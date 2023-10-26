<?php

namespace App\Http\Controllers\Dashboard\Manga;

use App\Models\Manga;
use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class StatusController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Retrieve a list of manga status.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $statusQuery = Taxonomy::query()->where("type", "status");

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $statusQuery->where("title", "LIKE", "%$title%");
    }

    $statuses = $statusQuery->latest()->fastPaginate(20);
    return view("dashboard.mangas.status.index", compact("statuses"));
  }

  /**
   * Create a new status.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.mangas.status.create");
  }

  /**
   * Store a new status.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $statusData = $request->validate([
      "title" => ["required"],
    ]);

    $statusData["slug"] = Str::slug($statusData["title"], "-");
    $statusData["type"] = "status";
    Taxonomy::create($statusData);
    Cache::flush();
    return redirect(route("dashboard.mangas_status.index"))->with("success", __("Status has been created!"));
  }

  /**
   * Edit a status.
   *
   * @param  $id
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
    $status = Taxonomy::where("type", "status")->findOrFail($id);
    return view("dashboard.mangas.status.edit", compact("status"));
  }

  /**
   * Update the specified status.
   *
   * @param  $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update($id, Request $request)
  {
    $status = Taxonomy::where("type", "status")->findOrFail($id);

    $statusData = $request->validate([
      "title" => ["required"],
      "slug" => ["required", "alpha_dash", Rule::unique(Taxonomy::class, "slug")->ignore($status)],
    ]);

    $statusData["slug"] = strtolower($statusData["slug"]);

    $status->update($statusData);
    Cache::flush();

    return back()->with("success", __("Status has been updated!"));
  }

  /**
   * Delete the specified status.
   *
   * @param  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete($id)
  {
    $status = Taxonomy::where("type", "status")->findOrFail($id);
    $status
      ->taxables()
      ->where("taxable_type", Manga::class)
      ->detach();

    $status->delete();
    Cache::flush();

    return back()->with("success", __("Status has been deleted."));
  }
}
