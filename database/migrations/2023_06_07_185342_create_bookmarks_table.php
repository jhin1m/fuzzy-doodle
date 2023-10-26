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
    Schema::create("bookmarks", function (Blueprint $table) {
      $table->id();
      $table
        ->foreignId("user_id")
        ->constrained()
        ->onDelete("cascade");
      $table->morphs("bookmarkable");

      $table->index(["bookmarkable_id", "bookmarkable_type"]);

      $table->unsignedBigInteger("collection_id")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("bookmarks");
  }
};
