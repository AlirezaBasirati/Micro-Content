<?php

use App\Services\ProductService\V1\Models\Attribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_group_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('type');
            $table->tinyInteger('searchable')->nullable();
            $table->tinyInteger('filterable')->nullable();
            $table->tinyInteger('comparable')->nullable();
            $table->tinyInteger('visible')->nullable();
            $table->unsignedTinyInteger('status')->default(Attribute::STATUS_ACTIVE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};
