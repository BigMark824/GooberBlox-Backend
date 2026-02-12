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
        Schema::create('server_group_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('server_id')
                ->constrained('servers')
                ->cascadeOnDelete();

            $table->foreignId('server_group')
                ->constrained('server_groups')
                ->cascadeOnDelete();

            $table->unique(['server_id', 'server_group']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_group_members');
    }
};
