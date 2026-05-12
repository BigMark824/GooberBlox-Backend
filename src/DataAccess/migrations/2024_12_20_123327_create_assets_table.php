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
            $table->unsignedBigInteger('asset_hash_id')->nullable();
            $table->bigInteger('asset_categories')->nullable();
            $table->bigInteger('asset_genres')->nullable();
            $table->string('name', 50);
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('current_version_id')->nullable();
            $table->unsignedBigInteger('universe_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_archived')->nullable();
            $table->timestamps();

            $table->foreign('asset_hash_id')
                  ->references('id')
                  ->on('asset_hashes')
                  ->nullOnDelete();
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
