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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id');
            $table->bigInteger('owner_user_id');
            $table->bigInteger('previous_owner_id')->nullable();
            $table->string('name');
            $table->bigInteger('emblem_id')->nullable();
            $table->boolean('has_clan')->default(false);
            $table->text('description')->nullable();
            $table->boolean('public_entry_allowed')->default(false);
            $table->boolean('bc_only')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
