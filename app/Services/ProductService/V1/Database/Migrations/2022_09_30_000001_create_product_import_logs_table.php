<?php

use App\Services\ProductService\V1\Models\ProductImportLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_import_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('actor_id');
            $table->string('file_path')->nullable();
            $table->unsignedTinyInteger('status')->default(ProductImportLog::STATUS_NEW);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_import_logs');
    }
};
