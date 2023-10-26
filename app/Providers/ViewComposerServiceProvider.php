<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    // $this->app->register(ViewComposerServiceProvider::class);
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    if (file_exists(storage_path("installed"))) {
      View::composer(["dashboard.includes.header"], function ($view) {
        $links = Config::get("dashboard-menu");

        $view->with([
          "links" => $links,
        ]);
      });
    }
  }
}
