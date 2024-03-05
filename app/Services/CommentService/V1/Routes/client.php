<?php

use App\Services\CommentService\V1\Controllers\Client\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'authenticate'])->prefix('api')->group(function () {
    Route::prefix('app/v1/comments/')->name('comments.')->group(function () {
        Route::get('', [CommentController::class, 'index'])->name('index');
        Route::post('', [CommentController::class, 'store'])->name('store');

        Route::prefix('{comment}/')->group(function () {
            Route::delete('', [CommentController::class, 'destroy'])->name('destroy');

            Route::patch('score', [CommentController::class, 'createRating'])->name('score');
            Route::patch('recommendation', [CommentController::class, 'createRecommendation'])->name('recommendation');
        });
    });
});
