<?php

use App\Services\CampaignService\V1\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('authenticate')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {
                Route::prefix('campaigns')->name('campaigns.')->group(function () {
                    Route::get('/', [CampaignController::class, 'index'])->name('index');
                    Route::post('/', [CampaignController::class, 'store'])->name('store');

                    Route::prefix('{campaign:slug}')->name('single.')->group(function () {
                        Route::patch('/', [CampaignController::class, 'update'])->name('update');
                        Route::get('/', [CampaignController::class, 'show'])->name('show');
                        Route::delete('/', [CampaignController::class, 'destroy'])->name('destroy');
                        Route::get('/products', [CampaignController::class, 'products'])->name('products');
                        Route::get('/sliders', [CampaignController::class, 'sliders'])->name('sliders');
                        Route::post('/product/assign', [CampaignController::class, 'assignProducts'])->name('assign-products');
                        Route::post('/products/import', [CampaignController::class, 'assignProductsViaFile'])->name('assign-products-via-file');

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
