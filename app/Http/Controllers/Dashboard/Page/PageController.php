<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    $this->middleware("can:viewAny," . Page::class)->only("index");
    $this->middleware("can:create," . Page::class)->only(["create", "store"]);
    $this->middleware("can:update,page")->only(["edit", "update"]);
    $this->middleware("can:delete,page")->only("delete");
  }

  /**
   * Retrieve a list of pages and display them in the dashboard.pages-list view.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $pagesQuery = Page::query();
    if ($request->filled("filter")) {
      $title = $request->input("filter");

      $pagesQuery->where(function ($pagesQuery) use ($title) {
        $pagesQuery
          ->where("title", "LIKE", "%" . $title . "%")
          ->orWhere("slug", "LIKE", "%" . $title . "%");
      });
    }

    $pages_pagination = $pagesQuery->latest()->fastPaginate(20);

    return view("dashboard.pages.index", compact("pages_pagination"));
  }

  /**
   * Display the new page form in the dashboard.new-page view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view("dashboard.pages.create");
  }

  /**
   * Create a new page based on the provided request data.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $pageData = $request->validate([
      "title" => ["required", "min:3", "max:60"],
      "slug" => ["required", "alpha_dash", Rule::unique("pages", "slug")],
      "content" => "nullable",
    ]);

    $pageData["slug"] = strtolower($pageData["slug"]);
    $pageData["user_id"] = auth()->id();

    Page::create($pageData);

    return redirect(route("dashboard.pages.index"))->with(
      "success",
      __("Page has been created")
    );
  }

  /**
   * Display the edit page form in the dashboard.edit-page view.
   *
   * @param  \App\Models\Page  $page
   * @return \Illuminate\View\View
   */
  public function edit(Page $page)
  {
    return view("dashboard.pages.edit", ["page" => $page]);
  }

  /**
   * Update the provided page with the given request data.
   *
   * @param  \App\Models\Page  $page
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Page $page, Request $request)
  {
    $pageData = $request->validate([
      "title" => ["required", "min:3", "max:60"],
      "slug" => ["required", Rule::unique("pages", "slug")->ignore($page->id)],
      "content" => "nullable",
    ]);

    $pageData["slug"] = strtolower($pageData["slug"]);
    $page->update($pageData);
    return back()->with("success", __("Page has been updated"));
  }

  /**
   * Delete the specified page.
   *
   * @param  \App\Models\Page  $page
   * @return \Illuminate\Http\RedirectResponse
   */
  public function delete(Page $page)
  {
    $page->delete();

    return back()->with("success", __("Page has been deleted"));
  }

  /**
   * Retrieve a list of deleted pages.
   *
   * @return \Illuminate\View\View
   */
  public function deleted(Request $request)
  {
    $pagesQuery = Page::onlyTrashed();

    if ($request->filled("filter")) {
      $title = $request->input("filter");
      $pagesQuery->where("values->title", "LIKE", "%$title%");
    }

    $pages_pagination = $pagesQuery->latest()->fastPaginate(20);

    return view("dashboard.pages.deleted", compact("pages_pagination"));
  }

  /**
   * Restore a deleted page.
   *
   * @param  \App\Models\Page  $page
   * @return \Illuminate\Http\RedirectResponse
   */
  public function restore($id)
  {
    $page = Page::withTrashed()->findOrFail($id);
    $page->restore();

    return redirect(route("dashboard.pages.deleted"))->with(
      "success",
      __("Page has been restored")
    );
  }

  /**
   * Permanently delete a page.
   *
   * @param  \App\Models\Page  $page
   * @return \Illuminate\Http\RedirectResponse
   */
  public function hard_delete($id)
  {
    $page = Page::withTrashed()->findOrFail($id);
    $page->forceDelete();

    return redirect(route("dashboard.pages.deleted"))->with(
      "success",
      __("Page has been permanently deleted")
    );
  }
}
