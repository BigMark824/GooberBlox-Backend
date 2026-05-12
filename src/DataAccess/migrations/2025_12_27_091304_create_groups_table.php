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
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('previous_owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->foreignId('emblem_id')->nullable()->constrained('assets')->nullOnDelete();
            $table->boolean('has_clan')->default(false);
            $table->text('description')->nullable();
            $table->boolean('public_entry_allowed')->default(false);
            $table->boolean('bc_only')->default(false);
            $table->boolean('is_locked');
            $table->timestamps();

            $table->unique('agent_id');
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
