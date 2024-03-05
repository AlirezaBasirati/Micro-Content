<?php

use App\Services\ProductService\V1\Controllers\Admin\BrandController;
use App\Services\ProductService\V1\Controllers\Client\FlatProductController;
use App\Services\ProductService\V1\Controllers\Admin\WidgetController;
use App\Services\ProductService\V1\Controllers\Client\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('app')->name('client.')->group(function () {
        Route::prefix('v1')->name('v1.')->group(function () {
            Route::prefix('flat-products')->name('flat-products.')->group(function () {
                Route::get('/', [FlatProductController::class, 'index'])->name('index');
                Route::get('/filters', [FlatProductController::class, 'filters'])->name('filters');
                Route::get('/leach', [FlatProductController::class, 'leach'])->name('leach');
                Route::get('/sitemap', [FlatProductController::class, 'sitemap'])->name('sitemap');
                Route::middleware('Authenticate')->get('/export', [FlatProductController::class, 'exportCsv'])->name('export-csv');
                Route::get('/fetch', [FlatProductController::class, 'fetch'])->name('fetch');
                Route::post('/by-ids', [FlatProductController::class, 'listById'])->name('list-by-id-and-store');
                Route::get('/{sku}', [FlatProductController::class, 'showBySku'])->name('showBySku');

            });
            Route::get('/menu/attribute', [FlatProductController::class, 'menuByAttribute'])->name('menu-by-attribute');
            Route::get('/menu/create-attribute', [FlatProductController::class, 'createMenuByAttribute'])->name('menu-create-attribute');

            Route::prefix('search')->name('search.')->group(function () {
                Route::get('/recent', [FlatProductController::class, 'recentSearch'])->name('recent');
                Route::get('/popular', [FlatProductController::class, 'popularSearch'])->name('popular');
                Route::get('/', [FlatProductController::class, 'search'])->name('index');
            });

            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::get('{category:slug}/breadcrumb', [CategoryController::class, 'breadcrumb'])->name('breadcrumb');

                Route::prefix('{category}')->name('single.')->group(function () {
                    Route::get('/children', [CategoryController::class, 'showChildren'])->name('show-children');
                    Route::get('/nested', [CategoryController::class, 'showNested'])->name('show-nested');

                });
            });

            Route::prefix('brands')->name('brands.')->group(function () {
                Route::get('/', [BrandController::class, 'index'])->name('index');

                Route::prefix('{brand}')->name('single.')->group(function () {
                    Route::get('/', [BrandController::class, 'show'])->name('show');
                    Route::get('/products', [BrandController::class, 'getProducts'])->name('get-products');

                });
            });

            Route::prefix('widgets')->name('widgets.')->group(function () {
                Route::prefix('{widget:slug}')->name('single.')->group(function () {
                    Route::get('/', [WidgetController::class, 'show'])->name('show');

                });
            });
        });
    });
});
