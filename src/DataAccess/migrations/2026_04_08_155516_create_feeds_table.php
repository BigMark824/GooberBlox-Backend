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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('item_id')->default(0);
            $table->string('item_type')->nullable();
            $table->string('action_type')->index();
            $table->text('description')->nullable();
            $table->timestamp('action_date')->index();
            $table->timestamp('harvest_date')->nullable()->index();
            $table->timestamps();

            $table->index(['user_id', 'action_type', 'action_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
