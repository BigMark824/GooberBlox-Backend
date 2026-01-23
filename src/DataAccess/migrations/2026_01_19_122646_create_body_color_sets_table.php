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
        Schema::create('body_color_sets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('head_color_id');
            $table->integer('left_arm_color_id');
            $table->integer('left_leg_color_id');
            $table->integer('right_arm_color_id');
            $table->integer('right_leg_color_id');
            $table->integer('torso_color_id');
            $table->string('body_color_set_hash')->nullable()->comment('obsolete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_color_sets');
    }
};
