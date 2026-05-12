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
            $table->foreignId('version_id')->constrained('allowed_security_versions')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['version_id', 'md5_hash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowed_md5_hashes');
    }
};
