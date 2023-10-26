<?php

namespace App\Providers;

use App\Models\Plugin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
  public function register()
  {
    // Register any common plugin services if needed
  }

  public function boot()
  {
    $this->loadPlugins();
  }

  private function loadPlugins(): void
  {
    if (file_exists(storage_path("installed"))) {
      $plugins = Plugin::where("active", true)->get();
      $pluginPath = base_path("plugins");

      foreach ($plugins as $plugin) {
        $pluginFile = $pluginPath . "/" . $plugin->name . "/plugin.php";
        $pluginCore = $pluginPath . "/" . $plugin->name . "/core.php";
        $routeFile = $pluginPath . "/" . $plugin->name . "/routes.php";
        $viewPath = $pluginPath . "/" . $plugin->name . "/views";
        if (File::exists($pluginFile)) {
          require $pluginFile;
          if (File::exists($pluginCore)) {
            require $pluginCore;
          }
          if (File::exists($routeFile)) {
            Route::middleware("web")->group($routeFile);
            if (File::exists($viewPath)) {
              View::addNamespace($plugin->name, $viewPath);
            }
          }
        }
      }
    }
  }
}
