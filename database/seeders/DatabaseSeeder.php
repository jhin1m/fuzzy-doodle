<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Ad;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    settings()->set("name", env("APP_NAME", "Laravel"));
    settings()->set("url", env("APP_URL", "http://localhost"));
    settings()->set("https-force", 0);
    settings()->set("locale", "en");
    settings()->set("description", "Website Description");

    settings()->set("image-driver", "gd");
    settings()->set("extension", "webp");
    settings()->set("quality", "80");

    settings()->set("theme.active", "default");
    settings()->set("theme.mode", "dark");
    settings()->set("theme.slider", "enabled");

    settings()->set("mail.driver", "sendmail");
    settings()->set("mail.host", "smtp.mailgun.org");
    settings()->set("mail.port", "587");
    settings()->set("mail.address", "admin@localhost");
    settings()->set("mail.encryption", "tls");

    settings()->set("seo.manga.title", "Manga :title");
    settings()->set("seo.manga.description", "manga :title translated , :title translated , all chapters of :title translated");
    settings()->set("seo.chapter.title", "Manga :manga - Chapter :chapter");
    settings()->set(
      "seo.chapter.description",
      "manga :manga translated , :manga translated , all chapters of :manga translated, chapter :chapter translated , :chapter translated"
    );

    settings()->set("seo.mangas.title", "Mangas List");
    settings()->set("seo.mangas.description", "Mangas List");

    Ad::create([
      "name" => "Above Popular (Home)",
      "identifier" => "above-popular-home",
      "description" => "Above Popular (Home)",
      "type" => "script",
      "script" => "Above Popular Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Above Latest (Home)",
      "identifier" => "above-latest-home",
      "description" => "Above Latest (Home)",
      "type" => "script",
      "script" => "Above Latest Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Above Chapters (Home)",
      "identifier" => "above-chapters-home",
      "description" => "Above Chapters (Home)",
      "type" => "script",
      "script" => "Above Chapters Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Above Title (Single Manga)",
      "identifier" => "above-title-manga",
      "description" => "Above Title (Single Manga)",
      "type" => "script",
      "script" => "Above Title Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Below Information (Single Manga)",
      "identifier" => "below-information-manga",
      "description" => "Below Information (Single Manga)",
      "type" => "script",
      "script" => "Below Information Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Above Chapter Images (Single Chapter)",
      "identifier" => "above-images-chapter",
      "description" => "Above Chapter Images (Single Chapter)",
      "type" => "script",
      "script" => "Above Chapter Images Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Below Chapter Images (Single Chapter)",
      "identifier" => "below-images-chapter",
      "description" => "below Chapter Images (Single Chapter)",
      "type" => "script",
      "script" => "Below Chapter Images Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Floating Bottom (All Pages)",
      "identifier" => "float-bottom",
      "description" => "Floating Bottom (All Pages)",
      "type" => "script",
      "script" => "Floating Bottom Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Floating Left (All Pages)",
      "identifier" => "float-left",
      "description" => "Floating Left (All Pages)",
      "type" => "script",
      "script" => "Floating Left Ad",
      "is_active" => false,
    ]);

    Ad::create([
      "name" => "Floating Right (All Pages)",
      "identifier" => "float-right",
      "description" => "Floating Right (All Pages)",
      "type" => "script",
      "script" => "Floating Right Ad",
      "is_active" => false,
    ]);

    Taxonomy::create([
      "title" => "Manga",
      "slug" => "manga",
      "description" => "Manga Type Manga",
      "type" => "type",
    ]);

    Taxonomy::create([
      "title" => "Manhua",
      "slug" => "manhua",
      "description" => "Manhua Type Manhua",
      "type" => "type",
    ]);

    Taxonomy::create([
      "title" => "Manhwa",
      "slug" => "manhwa",
      "description" => "Manhwa Type Manhwa",
      "type" => "type",
    ]);

    Taxonomy::create([
      "title" => "Ongoing",
      "slug" => "ongoing",
      "description" => "Manga Status Ongoing",
      "type" => "status",
    ]);

    Taxonomy::create([
      "title" => "Completed",
      "slug" => "completed",
      "description" => "Manga Status Completed",
      "type" => "status",
    ]);

    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    $permissions = [
      "view_dashboard",
      "see_stats", // 2.3
      "view_mangas",
      "create_mangas",
      "edit_own_mangas",
      "edit_all_mangas",
      "delete_own_mangas",
      "delete_all_mangas",
      "restore_deleted_mangas",
      "view_chapters",
      "create_chapters",
      "edit_own_chapters",
      "edit_all_chapters",
      "delete_own_chapters",
      "delete_all_chapters",
      "bulk_upload_chapters",
      "view_taxonomies",
      "create_taxonomies",
      "edit_taxonomies",
      "delete_taxonomies",
      "view_pages",
      "create_pages",
      "edit_pages",
      "delete_pages",
      "restore_deleted_pages",
      "view_comments",
      "edit_comments",
      "delete_comments",
      "view_users",
      "create_users",
      "edit_users",
      "delete_users",
      "restore_deleted_users",
      "view_roles",
      "create_roles",
      "edit_roles",
      "delete_roles",
      "view_permissions",
      "create_permissions",
      "edit_permissions",
      "delete_permissions",
      // "view_ads",
      // "create_ads",
      // "edit_ads",
      // "delete_ads",
      "view_settings",
      "edit_settings",
      "disable_ads",
      "view_logs",
      "view_plugins", // 2.3
      "edit_plugins", // 2.3
    ];

    foreach ($permissions as $permission) {
      Permission::create(["name" => $permission]);
    }

    // Create roles and assign permissions
    Role::create(["name" => "super admin"]);
    $adminRole = Role::create(["name" => "admin"]);
    $adminRole->givePermissionTo(Permission::all());

    $editorRole = Role::create(["name" => "editor"]);
    $editorRole->givePermissionTo([
      "view_dashboard",
      "view_mangas",
      "create_mangas",
      "edit_own_mangas",
      "delete_own_mangas",
      "view_chapters",
      "create_chapters",
      "edit_own_chapters",
      "delete_own_chapters",
    ]);

    Role::create(["name" => "user"]);

    // Create the admin user
    User::create([
      "username" => "admin",
      "email" => "admin@admin.com",
      "password" => Hash::make("adminadmin"),
      "email_verified_at" => now(),
      "remember_token" => Str::random(10),
    ])->assignRole("super admin");
  }
}
