<?php

use App\Services\SpecialOfferService\V1\Controllers\SpecialOfferController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('authenticate')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {
                Route::prefix('special-offers')->name('special-offers.')->group(function () {
                    Route::get('/', [SpecialOfferController::class, 'index'])->name('index');
//                    Route::post('/assign', [SpecialOfferController::class, 'assignProducts'])->name('assign-products');
//                    Route::post('/import', [SpecialOfferController::class, 'syncProductsViaFile'])->name('sync-products-via-file');

                    Route::prefix('{specialOffer}')->name('single.')->group(function () {
                        Route::middleware('Authenticate')->delete('/', [SpecialOfferController::class, 'destroy'])->name('destroy');
                    });
                });
            });
        });

        Route::prefix('app')->name('client.')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {

            });
        });
    });
});
