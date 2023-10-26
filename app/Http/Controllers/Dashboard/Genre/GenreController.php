<?php

namespace App\Http\Controllers\Dashboard\Genre;

use App\Models\Manga;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class GenreController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the list of genres.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $genresQuery = Taxonomy::query()->where("type", "genre");

    if ($request->filled("filter")) {
      $title = $request->input("filter");

      $genresQuery->where("name", "LIKE", "%" . $title . "%");
    }

    $genres = $genresQuery->latest()->fastPaginate(20);

    return view("dashboard.genres.index", compact("genres"));
  }

  /**
   * Create a new genre.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.genres.create");
  }

  /**
   * Store a new genre.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $genreData = $request->validate([
      "title" => ["required"],
      "slug" => ["required", "alpha_dash", Rule::unique(Taxonomy::class, "slug")],
    ]);

    $genreData["slug"] = strtolower($genreData["slug"]);
    $genreData["type"] = "genre";
    Taxonomy::create($genreData);
    Cache::flush();
    return back()->with("success", __("Genre has been created"));
  }

  /**
   * Edit a genre.
   *
   * @param  \App\Models\Genre  $genre
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
    $genre = Taxonomy::where("type", "genre")->findOrFail($id);
    return view("dashboard.genres.edit", compact("genre"));
  }

  /**
   * Update the specified genre.
   *
   * @param  \App\Models\Genre  $genre
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update($id, Request $request)
  {
    $genre = Taxonomy::where("type", "genre")->findOrFail($id);

    $genreData = $request->validate([
      "title" => ["required"],
      "slug" => ["required", "alpha_dash", Rule::unique(Taxonomy::class, "slug")->ignore($genre)],
    ]);

    $genreData["slug"] = strtolower($genreData["slug"]);

    $genre->update($genreData);
    Cache::flush();
    return back()->with("success", __("Genre has been updated"));
  }

  /**
   * Delete the specified genre.
   *
   * @param  \App\Models\Genre  $genre
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete($id)
  {
    $genre = Taxonomy::where("type", "genre")->findOrFail($id);
    $genre
      ->taxables()
      ->where("taxable_type", Manga::class)
      ->detach();

    $genre->delete();
    Cache::flush();
    return back()->with("success", __("Genre has been deleted"));
  }
}
