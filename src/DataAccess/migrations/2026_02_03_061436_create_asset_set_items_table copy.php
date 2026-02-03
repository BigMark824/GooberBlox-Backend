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
            $table->bigInteger('asset_set_id');
            $table->bigInteger('asset_target_id');
            $table->bigInteger('asset_version_id')->nullable();
            $table->bigInteger('asset_type_id');
            $table->integer('sortOrder');
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