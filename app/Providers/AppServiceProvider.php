<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    if (file_exists(storage_path("installed"))) {
      if (settings()->get("https-force")) {
        \URL::forceScheme("https");
      }

      if (settings()->get("image-driver")) {
        config(["image.driver" => settings()->get("image-driver")]);
      }

      config(["app.name" => settings()->get("name")]);
      config(["app.url" => settings()->get("url")]);
      config(["app.locale" => settings()->get("locale")]);
      config(["log-viewer.back_to_system_url" => settings()->get("url")]);

      config(["theme.active" => settings()->get("theme.active", "default")]);

      config([
        "mail" => [
          "driver" => settings()->get("mail.driver", "smtp"),
          "host" => settings()->get("mail.host", "smtp.mailgun.org"),
          "port" => settings()->get("mail.port", "587"),
          "username" => settings()->get("mail.username"),
          "password" => settings()->get("mail.password"),
          "encryption" => settings()->get("mail.encryption"),
          "from" => [
            "address" => settings()->get("mail.address", "test@localhost"),
            "name" => settings()->get("name"),
          ],
        ],
      ]);

      LogViewer::auth(function ($request) {
        if (!auth()->check()) {
          return false;
        }

        return auth()
          ->user()
          ->can("view_logs");
      });
    }
    // else {
    //   if (isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])) {
    //     $currentUri = $_SERVER["REQUEST_URI"];

    //     if (strcmp($currentUri, "/install") < 0) {
    //       header("Location: /install");
    //       die();
    //     }
    //   }
    // }
  }
}
