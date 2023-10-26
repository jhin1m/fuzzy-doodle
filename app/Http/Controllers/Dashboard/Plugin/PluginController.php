<?php

namespace App\Http\Controllers\Dashboard\Plugin;

use Exception;
use App\Models\Plugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class PluginController extends Controller
{
  /**
   * Construct the controller.
   */
  public function __construct()
  {
    // $this->middleware("can:viewAny," . Page::class)->only("index");
    // $this->middleware("can:create," . Page::class)->only(["create", "store"]);
    // $this->middleware("can:update,page")->only(["edit", "update"]);
    // $this->middleware("can:delete,page")->only("delete");
  }

  /**
   * Retrieve a list of plugins.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    // $pluginsQuery = Plugin::query();
    // if ($request->filled("filter")) {
    //   $title = $request->input("filter");

    //   $pluginsQuery->where(function ($pluginsQuery) use ($title) {
    //     $pluginsQuery->where("title", "LIKE", "%" . $title . "%")->orWhere("slug", "LIKE", "%" . $title . "%");
    //   });
    // }

    // $plugins = $pluginsQuery->latest()->fastPaginate(20);

    $plugins = collect();
    $pluginPath = base_path("plugins");
    if (File::exists($pluginPath)) {
      $pluginDirectories = File::directories($pluginPath);

      foreach ($pluginDirectories as $plugin) {
        $pluginName = basename($plugin);
        $pluginFilePath = $plugin . "/plugin.php";

        if (File::exists($pluginFilePath)) {
          $pluginInfo = require $pluginFilePath;
          $pluginInfo["folder"] = $pluginName;
          $plugins->push($pluginInfo);
        }
      }
    }

    return view("dashboard.plugins.index", compact("plugins"));
  }

  public function activate($plugin)
  {
    $pluginPath = base_path("plugins");
    $pluginFolder = $pluginPath . "/" . $plugin;
    $pluginFile = $pluginFolder . "/plugin.php";
    $pluginMigrations = $pluginFolder . "/database/migrations";
    $pluginSeeders = $pluginFolder . "/database/seeders";

    if (File::exists($pluginFile)) {
      $pluginDB = Plugin::where("name", $plugin)->first();

      if (!$pluginDB) {
        if (File::exists($pluginMigrations)) {
          try {
            Artisan::call("migrate", ["--path" => "plugins/{$plugin}/database/migrations/", "--force" => true]);
          } catch (Exception $err) {
            return back()->with("error", $err->getMessage());
          }
        }

        if (File::exists($pluginSeeders)) {
          $seederFileName = "{$plugin}Seeder.php";
          $seederPath = database_path("seeders/{$seederFileName}");
          File::copyDirectory($pluginSeeders, database_path("seeders"));

          try {
            Artisan::call("db:seed", ["--class" => "Database\\Seeders\\{$plugin}Seeder", "--force" => true]);
          } catch (Exception $err) {
            return back()->with("error", $err->getMessage());
          }
        }

        Plugin::create(["name" => $plugin, "active" => 1]);
        return back()->with("success", __("Plugin has been Activated!"));
      } else {
        if ($pluginDB->active) {
          return back()->with("error", __("Plugin is already active"));
        } else {
          $pluginDB->activate();
          return back()->with("success", __("Plugin has been Activated!"));
        }
      }
    }
  }

  public function deactivate($plugin)
  {
    $pluginDB = Plugin::where("name", $plugin)->first();

    if ($pluginDB) {
      $pluginPath = base_path("plugins");
      $pluginFolder = $pluginPath . "/" . $plugin;

      // $pluginMigrations = $pluginFolder . "/database/migrations";
      // if (File::exists($pluginMigrations)) {
      //   try {
      //     Artisan::call("migrate:rollback", ["--path" => $pluginMigrations]);
      //   } catch (Exception $err) {
      //     return back()->with("error", $err->getMessage());
      //   }
      // }

      $pluginDB->deactivate();
      return back()->with("success", __("Plugin has been Deactivated!"));
    }

    return back()->with("error", __("Plugin not found"));
  }
}
