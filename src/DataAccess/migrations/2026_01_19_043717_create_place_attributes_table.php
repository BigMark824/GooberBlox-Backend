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
            $table->foreignId('place_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('place_type_id')->nullable()->constrained('place_types')->nullOnDelete();
            $table->boolean('use_place_media_for_thumb')->default(false);
            $table->boolean('overrides_default_avatar')->default(false);
            $table->boolean('use_portrait_mode')->default(false);
            $table->foreignId('universe_id')->nullable()->constrained('universes')->nullOnDelete();
            $table->boolean('is_filtering_enabled')->nullable();
            $table->timestamps();

            $table->unique('place_id');
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
