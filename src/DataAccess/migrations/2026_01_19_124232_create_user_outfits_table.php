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
        Schema::create('user_outfits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('outfit_id');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->boolean('is_editable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_outfits');
    }
};
