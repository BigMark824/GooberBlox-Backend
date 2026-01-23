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
        Schema::create('asset_hashes', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_type_id');
            $table->integer('creator_type');
            $table->string('hash', 36);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_reviewed')->default(false);
            $table->bigInteger('creator_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_hashes');
    }
};
