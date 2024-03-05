<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mongodb')->hasTable('flat_products')) {
            Schema::connection('mongodb')->table('flat_products', function (Blueprint $table) {
                $this->indexing($table);
            });
        } else {
            Schema::connection('mongodb')->create('flat_products', function (Blueprint $table) {
                $this->indexing($table);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function indexing(Blueprint $table)
    {
        $table->index('store_id');
        $table->index('merchant_id');
        $table->index('master_id');
        $table->index('id');
        $table->index('type');
        $table->index('sku');
        $table->index('brand_id');
        $table->index('categories.id');
        $table->index('name');
        $table->index('status');
        $table->index('visibility');
        $table->unique(['merchant_id', 'store_id', 'sku']);
    }
};
