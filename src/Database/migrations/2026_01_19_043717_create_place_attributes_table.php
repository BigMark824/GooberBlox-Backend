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
        Schema::create('place_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('place_id');
            $table->bigInteger('place_type_id');
            $table->boolean('use_place_media_for_thumb');
            $table->boolean('overrides_default_avatar');
            $table->boolean('use_portrait_mode');
            $table->bigInteger('universe_id');
            $table->boolean('is_filtering_enabled');
            $table->timestamps();

            $table->foreign('place_type_id')
                  ->references('id')
                  ->on('place_types')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_attributes');
    }
};
