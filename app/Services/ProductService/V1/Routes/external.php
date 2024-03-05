<?php

use App\Services\ProductService\V1\Controllers\External\Product\IntegrateController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/external/v1')->name('external.product.v1.')->group(function () {

    Route::post('/products', [IntegrateController::class, 'products'])->name('store.products');

});
