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
        Schema::create('universes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->integer("creator_target_id")->comment('Gets the actual Id of the creator of the universe. Group Id if it is a group, user Id if it is a user');
            $table->bigInteger('root_place_id')->nullable();
            $table->string("privacy_type");
            $table->smallInteger("creator_type");
            $table->boolean('api_services')->nullable()->comment('Allows for datastores, httpservice and other funny studio things');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universes');
    }
};
