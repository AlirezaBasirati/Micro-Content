<?php

use App\Services\SpecialOfferService\V1\Models\SpecialOffer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('special_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_to')->nullable();
            $table->unsignedTinyInteger('status')->default(SpecialOffer::STATUS_ACTIVE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_offers');
    }
};
