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
            $table->bigInteger('asset_id');
            $table->integer('version_number');
            $table->bigInteger('asset_hash_id');
            $table->bigInteger('parent_asset_version_id')->nullable();
            $table->integer('creator_type')->default(1 /* user */);
            $table->bigInteger('creator_target_id')->comment('Creator agent ID');
            $table->bigInteger('creating_universe_id')->nullable();
            $table->timestamps();
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
