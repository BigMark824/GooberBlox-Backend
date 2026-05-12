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
        Schema::create('datastores', function (Blueprint $table) {
            $table->id();
            $table->string('universe_id');
            $table->string('key');
            $table->string('type');
            $table->string('scope');
            $table->string('target');
            $table->text('value');
            $table->enum('datastore_type', ['Production', 'Sandbox']);
            $table->timestamps();
            $table->index(['universe_id', 'key', 'target']);
            $table->unique(['universe_id', 'datastore_type', 'type', 'scope', 'target', 'key'], 'datastores_identity_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datastores');
    }
};
