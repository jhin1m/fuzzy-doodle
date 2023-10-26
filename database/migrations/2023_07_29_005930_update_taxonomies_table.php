<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table("taxonomies", function (Blueprint $table) {
      $table->dropUnique("taxonomies_slug_unique");
      $table->unique(["slug", "type"]);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table("taxonomies", function (Blueprint $table) {
      $table->unique("slug");
      $table->dropUnique(["slug", "type"]);
    });
  }
};
