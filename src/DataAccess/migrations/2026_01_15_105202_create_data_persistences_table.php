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
        Schema::create('data_persistence', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('agent_id');
            $table->string('universe_id');
            $table->text('blob');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_persistence');
    }
};
