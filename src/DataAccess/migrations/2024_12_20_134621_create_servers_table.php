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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('host_name');
            $table->string('name');
            $table->bigInteger('server_farm_id');
            $table->integer('server_type_id');
            $table->integer('datacenter_id');
            $table->string('private_ip_address')->default("127.0.0.1");
            $table->string('primary_ip_address')->default("127.0.0.1");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
