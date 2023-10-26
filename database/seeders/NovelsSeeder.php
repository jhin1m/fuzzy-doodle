<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taxonomy;
use Spatie\Permission\Models\Permission;

class NovelsSeeder extends Seeder
{
  /**
   * Seed the novels database.
   */
  public function run(): void
  {
    settings()->set("seo.novel.title", "Novel :title");
    settings()->set("seo.novel.description", "novel :title translated , :title translated , all chapters of :title translated");

    settings()->set("seo.novel-chapter.title", "Novel :novel - Chapter :chapter");
    settings()->set(
      "seo.novel-chapter.description",
      "novel :novel translated , :novel translated , all chapters of :novel translated, chapter :chapter translated , :chapter translated"
    );

    settings()->set("seo.novels.title", "Novels List");
    settings()->set("seo.novels.description", "Novels List");

    Taxonomy::firstOrCreate(
      ["slug" => "novel"],
      [
        "title" => "Novel",
        "description" => "Novel",
        "type" => "type",
      ]
    );

    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    $permissions = [
      "view_novels",
      "create_novels",
      "edit_own_novels",
      "edit_all_novels",
      "delete_own_novels",
      "delete_all_novels",
      "restore_deleted_novels",
    ];

    foreach ($permissions as $permission) {
      Permission::create(["name" => $permission, "guard_name" => "web"]);
    }
  }
}
