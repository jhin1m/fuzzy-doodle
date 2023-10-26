<?php

namespace App\Http\Controllers\Dashboard\Manga;

use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Helpers\ChapterHelper;
use App\Http\Controllers\Controller;

class BulkController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    $this->middleware("can:viewAny," . Chapter::class)->only("index");
    $this->middleware("can:create," . Chapter::class)->only(["create", "store"]);
    $this->middleware("can:update,chapter")->only(["edit", "update"]);
    $this->middleware("can:delete,chapter")->only("delete");
  }

  /**
   * Display the form for bulk chapter creation.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    $mangas = Manga::orderBy("created_at", "desc")
      ->get()
      ->pluck("title", "id")
      ->toArray();
    return view("dashboard.chapters.bulk-create", compact("mangas"));
  }

  /**
     * Store multiple chapters from a zip file.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\RedirectResponse
     */
  public function store(Request $request)
  {
    return ChapterHelper::processBulk($request);
  }

  public function upload(Request $request)
  {
    return ChapterHelper::uploadBulkFile($request);
  }
}
