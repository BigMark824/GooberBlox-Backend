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
        Schema::create('asset_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->integer('version_number');
            $table->foreignId('asset_hash_id')->constrained('asset_hashes')->restrictOnDelete();
            $table->foreignId('parent_asset_version_id')->nullable()->constrained('asset_versions')->nullOnDelete();
            $table->integer('creator_type')->default(1 /* user */);
            $table->unsignedBigInteger('creator_target_id')->comment('Creator agent ID');
            $table->foreignId('creating_universe_id')->nullable()->constrained('universes')->nullOnDelete();
            $table->timestamps();

            $table->unique(['asset_id', 'version_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_versions');
    }
};
