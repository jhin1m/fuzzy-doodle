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
    Schema::table("chapters", function (Blueprint $table) {
      $table->index(["manga_id", "chapter_number", "user_id", "created_at"]);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table("chapters", function (Blueprint $table) {
      $table->dropIndex(["manga_id", "chapter_number", "user_id", "created_at"]);
    });
  }
};
