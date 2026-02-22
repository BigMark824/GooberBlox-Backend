<?php

use Brick\Math\BigInteger;
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
        Schema::create('premium_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('account_addon_type_id');
            $table->smallInteger('duration_type_id');
            $table->boolean('is_renewal')->default(false);
            $table->smallInteger('robux_credit_quantity_type_id');
            $table->smallInteger('robux_stipend_quantity_type_id');
            $table->smallInteger('robux_stipend_frequency_type_id');
            $table->smallInteger('showcase_allotment_type_id');
            $table->smallInteger('content_privilege_type_id');
            $table->smallInteger('advertising_suppression_type_id');
            $table->integer('granted_asset_list_id');
            $table->smallInteger('granted_badge_list_id');
            $table->bigInteger('granted_item_list_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_features');
    }
};
