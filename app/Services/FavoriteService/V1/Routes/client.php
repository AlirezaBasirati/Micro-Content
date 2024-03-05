<?php

use App\Services\FavoriteService\V1\Controllers\Client\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'authenticate'])->prefix('api')->group(function () {
    Route::prefix('client/v1/favorites/')->name('favorites.')->group(function () {
        Route::get('', [FavoriteController::class, 'index'])->name('index');
        Route::post('', [FavoriteController::class, 'store'])->name('store');
        Route::get('is-favorite', [FavoriteController::class, 'isFavorite'])->name('is-favorite');
        Route::delete('', [FavoriteController::class, 'unfavorite'])->name('unfavorite');

    });
});
