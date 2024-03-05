<?php

use App\Services\ContentManagerService\V1\Controllers\Client\SliderPositionController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('app')->name('client.')->group(function () {
        Route::prefix('v1')->name('v1.')->group(function () {
            Route::prefix('slider-positions')->name('slider-positions.')->group(function () {
                Route::prefix('{sliderPosition:slug}')->name('single.')->group(function () {
                    Route::get('/', [SliderPositionController::class, 'show'])->name('show');

                });
            });
        });
    });
});
