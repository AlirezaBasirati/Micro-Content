<?php

use App\Services\CommentService\V1\Controllers\Admin\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'authenticate'])->prefix('api')->group(function () {
    Route::prefix('admin/v1/comments/')->name('comments.')->group(function () {
        Route::get('', [CommentController::class, 'index'])->name('index');

        Route::prefix('{comment}/')->group(function () {
            Route::patch('', [CommentController::class, 'update'])->name('update');
            Route::delete('', [CommentController::class, 'destroy'])->name('destroy');
        });
    });
});
