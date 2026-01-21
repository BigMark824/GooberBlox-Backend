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
            $table->bigInteger('place_type_id')->nullable();
            $table->boolean('use_place_media_for_thumb')->default(false);
            $table->boolean('overrides_default_avatar')->default(false);
            $table->boolean('use_portrait_mode')->default(false);
            $table->bigInteger('universe_id')->nullable();
            $table->boolean('is_filtering_enabled')->nullable();
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
