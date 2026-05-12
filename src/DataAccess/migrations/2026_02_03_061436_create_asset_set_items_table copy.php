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
        Schema::create('asset_set_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('asset_set_id')->constrained('asset_sets')->cascadeOnDelete();
            $table->foreignId('asset_target_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('asset_version_id')->nullable()->constrained('asset_versions')->nullOnDelete();
            $table->bigInteger('asset_type_id');
            $table->integer('sortOrder');

            $table->unique(['asset_set_id', 'asset_target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_set_items');
    }
};
