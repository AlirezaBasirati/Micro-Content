<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->json('path')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('en_name')->nullable();
            $table->string('visible_in_menu')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('level');
            $table->unsignedBigInteger('position');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
