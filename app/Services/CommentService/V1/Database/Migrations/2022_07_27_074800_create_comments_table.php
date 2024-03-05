<?php

namespace App\Services\CommentService\V1\Database\migrations;

use App\Services\CommentService\V1\Enums\CommentsStatusEnum;
use App\Services\CommentService\V1\Enums\IsRecommendedStatus;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->index()
                ->nullable()
                ->constrained('comments')
                ->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('full_name')->nullable();
            $table->unsignedTinyInteger('status')->default(CommentsStatusEnum::NOT_APPROVED->value);
            $table->string('title')->nullable();
            $table->longText('body');
            $table->unsignedTinyInteger('rate')->default(0);
            $table->mediumText('positive_points')->nullable();
            $table->mediumText('negative_points')->nullable();
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
        Schema::dropIfExists('comments');
    }
};
