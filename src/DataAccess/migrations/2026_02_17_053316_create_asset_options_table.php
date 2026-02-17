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
        Schema::create('asset_options', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');

            $table->boolean('enable_comments')->nullable(false);
            $table->boolean('enable_ratings')->default(false);
            $table->boolean('is_copy_locked')->default(true);
            $table->boolean('is_friends_only')->default(false);

            $table->unsignedBigInteger('allowed_gear_categories')->default(0);

            $table->bigInteger('default_expiration_in_ticks')->nullable();

            $table->boolean('enforce_genre')->default(false);

            $table->unsignedTinyInteger('min_membership_type')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_options');
    }
};
