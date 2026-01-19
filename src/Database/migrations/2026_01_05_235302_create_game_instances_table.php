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
        Schema::create('game_instances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('place_id');
            $table->double('fps')->nullable();
            $table->integer('ping')->nullable();
            $table->integer('port');
            $table->json('player_ids')->nullable()->comment('Collection of all PlayerIds in the Instance.');
            $table->smallInteger('capacity')->nullable(0);
            $table->uuid('game_code');
            $table->bigInteger('server_id');
            $table->integer('matchmaking_context_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_instances');
    }
};
