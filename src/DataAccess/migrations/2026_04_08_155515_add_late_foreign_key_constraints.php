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
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('account_status_id')
                ->references('id')
                ->on('account_statuses')
                ->nullOnDelete();
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('universe_id')
                ->references('id')
                ->on('universes')
                ->nullOnDelete();

            $table->foreign('current_version_id')
                ->references('id')
                ->on('asset_versions')
                ->nullOnDelete();
        });

        Schema::table('universes', function (Blueprint $table) {
            $table->foreign('root_place_id')
                ->references('id')
                ->on('assets')
                ->nullOnDelete();
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->foreign('server_farm_id')
                ->references('id')
                ->on('server_farms')
                ->cascadeOnDelete();

            $table->foreign('datacenter_id')
                ->references('id')
                ->on('datacenters')
                ->restrictOnDelete();
        });

        Schema::table('game_instances', function (Blueprint $table) {
            $table->foreign('matchmaking_context_id')
                ->references('id')
                ->on('matchmaking_contexts')
                ->nullOnDelete();
        });

        Schema::table('accoutrements', function (Blueprint $table) {
            $table->foreign('user_asset_id')
                ->references('id')
                ->on('user_assets')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accoutrements', function (Blueprint $table) {
            $table->dropForeign(['user_asset_id']);
        });

        Schema::table('game_instances', function (Blueprint $table) {
            $table->dropForeign(['matchmaking_context_id']);
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign(['datacenter_id']);
            $table->dropForeign(['server_farm_id']);
        });

        Schema::table('universes', function (Blueprint $table) {
            $table->dropForeign(['root_place_id']);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['current_version_id']);
            $table->dropForeign(['universe_id']);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['account_status_id']);
        });
    }
};
