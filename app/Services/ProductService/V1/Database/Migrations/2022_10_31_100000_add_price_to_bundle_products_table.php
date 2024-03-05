<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bundle_products', function (Blueprint $table) {
            $table->bigInteger('price')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bundle_products', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
