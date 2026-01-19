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
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asset_type_id');
            $table->bigInteger('asset_hash_id')->nullable();
            $table->bigInteger('asset_categories')->nullable();
            $table->bigInteger('asset_genres')->nullable();
            $table->string('name', 50);
            $table->bigInteger('creator_id');
            $table->bigInteger('current_version_id')->default(1);
            $table->bigInteger('universe_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_archived')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
