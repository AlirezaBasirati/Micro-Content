<?php

use App\Services\ProductService\V1\Controllers\Client\FlatProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('internal')->name('internal.')->group(function () {
        Route::prefix('v1')->name('v1.')->group(function () {
            Route::prefix('marketing')->name('marketing.')->group(function () {
                Route::post('/category', [FlatProductController::class, 'checkMarketingCategories'])->name('check-marketing-categories');
                Route::post('/brand', [FlatProductController::class, 'checkMarketingBrandRules'])->name('check-marketing-brands');
                Route::post('/campaign', [FlatProductController::class, 'checkMarketingCampaignRules'])->name('check-marketing-campaigns');

            });

            Route::prefix('flat-products')->name('flat-products.')->group(function () {
                Route::post('/by-stores', [FlatProductController::class, 'listBySku'])->name('list-by-sku-and-store');
                Route::post('/sync-inventory', [FlatProductController::class, 'syncInventory'])->name('sync-inventory');

            });
        });
    });
});
