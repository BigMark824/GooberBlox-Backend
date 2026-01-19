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
        Schema::create('outfit_accoutrements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('outfit_id');
            $table->bigInteger('asset_id');
            $table->timestamps();

            $table->foreign('outfit_id')->references('id')->on('outfits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit_accoutrements');
    }
};
