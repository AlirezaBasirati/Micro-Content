<?php

use App\Services\ProductService\V1\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->unique();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('type')->default("simple");
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(Product::STATUS_INACTIVE);
            $table->string('slug')->nullable();
            $table->string('url_key');
            $table->string('tax_class');
            $table->unsignedTinyInteger('visibility');
            $table->unsignedTinyInteger('max_in_cart')->default(100);
            $table->unsignedTinyInteger('min_in_cart')->default(1);
            $table->string('barcode')->nullable();
            $table->unsignedBigInteger('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->foreignId('brand_id');
            $table->unsignedBigInteger('master_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
