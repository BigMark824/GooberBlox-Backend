<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('place_media_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('place_id');
            $table->bigInteger('media_asset_id');
            $table->bigInteger('uploader_user_id');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_media_items');
    }
};
