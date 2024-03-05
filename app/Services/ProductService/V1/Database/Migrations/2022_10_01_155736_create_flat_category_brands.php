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
        if (Schema::connection('mongodb')->hasTable('flat_category_brands')) {
            Schema::connection('mongodb')->table('flat_category_brands', function (Blueprint $table) {
                $this->indexing($table);
            });
        } else {
            Schema::connection('mongodb')->create('flat_category_brands', function (Blueprint $table) {
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
        $table->index('category_id');
    }
};
