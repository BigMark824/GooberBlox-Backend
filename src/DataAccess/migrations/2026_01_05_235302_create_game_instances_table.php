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
            $table->foreignId('place_id')->constrained('assets')->cascadeOnDelete();
            $table->double('fps')->nullable();
            $table->integer('ping')->nullable();
            $table->integer('port');
            $table->json('player_ids')->nullable()->comment('Collection of all PlayerIds in the Instance.');
            $table->unsignedInteger('player_count')->default(0)->index();
            $table->smallInteger('capacity')->nullable(0);
            $table->uuid('game_code')->unique();
            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->unsignedBigInteger('matchmaking_context_id')->nullable();
            $table->timestamps();

            $table->unique(['server_id', 'port']);
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
