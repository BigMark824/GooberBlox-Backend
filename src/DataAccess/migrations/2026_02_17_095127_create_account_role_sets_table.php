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
        Schema::create('account_role_sets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('role_set_id');

            $table->timestamps();

            $table->unique(['account_id', 'role_set_id']);

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->foreign('role_set_id')
                ->references('id')
                ->on('role_sets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_role_sets');
    }
};
