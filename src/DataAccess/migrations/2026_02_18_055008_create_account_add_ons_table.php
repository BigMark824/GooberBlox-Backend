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
        Schema::create('account_add_ons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('premium_feature_id')->constrained('premium_features')->restrictOnDelete();
            $table->timestamp('renewal');
            $table->timestamp('expiration');
            $table->unsignedBigInteger('robux_stipend_id');
            $table->timestamp('lease_expiration')->nullable();
            $table->uuid('worker_id')->nullable();
            $table->timestamp('completed');
            $table->timestamp('renewed_since')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_add_ons');
    }
};
