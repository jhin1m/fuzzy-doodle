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
    Schema::table("mangas", function (Blueprint $table) {
      $table->string("status");
      $table->index("status");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table("mangas", function (Blueprint $table) {
      $table->dropIndex("status");
      $table->dropColumn("status");
    });
  }
};
