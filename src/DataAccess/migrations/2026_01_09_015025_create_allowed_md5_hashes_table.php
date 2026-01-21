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
        Schema::create('allowed_md5_hashes', function (Blueprint $table) {
            $table->id();
            $table->string('md5_hash');
            $table->integer('version_id');

            $table->foreign('version_id')
                ->references('id')
                ->on('allowed_security_versions')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowed_m_d5_hashes');
    }
};
