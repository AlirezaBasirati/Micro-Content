<?php

use App\Services\ProductService\V1\Controllers\Admin\AttributeController;
use App\Services\ProductService\V1\Controllers\Admin\AttributeGroupController;
use App\Services\ProductService\V1\Controllers\Admin\AttributeSetController;
use App\Services\ProductService\V1\Controllers\Admin\AttributeValueController;
use App\Services\ProductService\V1\Controllers\Admin\BrandController;
use App\Services\ProductService\V1\Controllers\Admin\CategoryController;
use App\Services\ProductService\V1\Controllers\Admin\DraftProductController;
use App\Services\ProductService\V1\Controllers\Admin\FlatBrandController;
use App\Services\ProductService\V1\Controllers\Admin\FlatProductController;
use App\Services\ProductService\V1\Controllers\Admin\ProductController;
use App\Services\ProductService\V1\Controllers\Admin\ProductImageController;
use App\Services\ProductService\V1\Controllers\Admin\SearchController;
use App\Services\ProductService\V1\Controllers\Admin\WidgetController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::middleware('authenticate')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {
                Route::prefix('categories')->name('categories.')->group(function () {
                    Route::get('/', [CategoryController::class, 'index'])->name('index');
                    Route::post('/', [CategoryController::class, 'store'])->name('store');
                    Route::get('/search', [CategoryController::class, 'search'])->name('search');
                    Route::get('/sitemap', [CategoryController::class, 'sitemap'])->name('sitemap');

                    Route::prefix('{category}')->name('single.')->group(function () {
                        Route::post('/', [categoryController::class, 'update'])->name('update');
                        Route::get('/', [categoryController::class, 'show'])->name('show');
                        Route::get('/children', [categoryController::class, 'showChildren'])->name('show-children');
                        Route::get('/nested', [categoryController::class, 'showNested'])->name('show-nested');
                        Route::delete('/', [categoryController::class, 'destroy'])->name('destroy');
                        Route::get('/products', [categoryController::class, 'getProducts'])->name('get-products');

                    });
                });

                Route::prefix('products')->name('products.')->group(function () {
                    Route::post('import', [ProductController::class, 'importByFile'])->name('import');
                    Route::post('import/update', [ProductController::class, 'updateViaFile'])->name('update-via-file');
                    Route::post('/categories', [ProductController::class, 'bulkAssignProductCategory'])->name('bulk-assign-product-category');
                    Route::get('/', [ProductController::class, 'index'])->name('index');
                    Route::get('/search', [ProductController::class, 'search'])->name('search');
                    Route::post('/', [ProductController::class, 'store'])->name('store');
                    Route::post('/extended', [ProductController::class, 'extendedCreate'])->name('extended-create');
                    Route::get('/categories', [ProductController::class, 'productCategories'])->name('categories');
                    Route::post('/update', [ProductController::class, 'bulkUpdate'])->name('bulk-update');
                    Route::get('/export', [ProductController::class, 'exportCsv'])->name('export-csv');

                    Route::prefix('{product}')->name('single.')->group(function () {
                        Route::post('/admin', [ProductController::class, 'extendedUpdate'])->name('extended-update');
                        Route::patch('/', [ProductController::class, 'update'])->name('update');
                        Route::get('/', [ProductController::class, 'show'])->name('show');
                        Route::delete('/', [ProductController::class, 'destroy'])->name('destroy');
                        Route::post('/configurable', [ProductController::class, 'addConfigurableProduct'])->name('add-configurable-product');
                        Route::post('/configurable/remove', [ProductController::class, 'removeConfigurableProduct'])->name('remove-configurable-product');
                        Route::post('/bundle', [ProductController::class, 'addBundleProduct'])->name('add-bundle-product');
                        Route::post('/bundle/remove', [ProductController::class, 'removeBundleProduct'])->name('remove-bundle-product');
                        Route::post('/related', [ProductController::class, 'addRelatedProduct'])->name('add-related-product');
                        Route::post('/related/remove', [ProductController::class, 'removeRelatedProduct'])->name('remove-related-product');
                        Route::post('/category/assign', [ProductController::class, 'assignCategories'])->name('assign-categories');
                        Route::post('/category/unassign', [ProductController::class, 'unassignCategories'])->name('unassign-categories');
                        Route::post('/product-image', [ProductImageController::class, 'add'])->name('add-image');
                        Route::delete('/product-image/{productImage}', [ProductImageController::class, 'remove'])->name('remove-image');
                        Route::post('/product-values/{attributeValue}', [ProductController::class, 'attributeValue'])->name('product-values');
                        Route::delete('/product-values/{attributeValue}/remove', [ProductController::class, 'removeAttributeValue'])->name('product-values-remove');

                    });
                });

                Route::prefix('brands')->name('brands.')->group(function () {
                    Route::get('/', [BrandController::class, 'index'])->name('index');
                    Route::post('/', [BrandController::class, 'store'])->name('store');

                    Route::prefix('{brand}')->name('single.')->group(function () {
                        Route::post('/', [BrandController::class, 'update'])->name('update');
                        Route::get('/', [BrandController::class, 'show'])->name('show');
                        Route::delete('/', [BrandController::class, 'destroy'])->name('destroy');
                        Route::get('/products', [BrandController::class, 'getProducts'])->name('get-products');

                    });
                });

                Route::prefix('flat-brands')->name('flat-brands.')->group(function () {
                    Route::get('/', [FlatBrandController::class, 'index'])->name('index');

                });

                Route::prefix('attributes')->name('attributes.')->group(function () {
                    Route::get('/', [AttributeController::class, 'index'])->name('index');
                    Route::post('/', [AttributeController::class, 'store'])->name('store');

                    Route::prefix('{attribute}')->name('single.')->group(function () {
                        Route::patch('/', [AttributeController::class, 'update'])->name('update');
                        Route::get('/', [AttributeController::class, 'show'])->name('show');
                        Route::delete('/', [AttributeController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('attribute-values')->name('attribute-values.')->group(function () {
                    Route::get('/', [AttributeValueController::class, 'index'])->name('index');
                    Route::post('/', [AttributeValueController::class, 'store'])->name('store');

                    Route::prefix('{attributeValue}')->name('single.')->group(function () {
                        Route::patch('/', [AttributeValueController::class, 'update'])->name('update');
                        Route::get('/', [AttributeValueController::class, 'show'])->name('show');
                        Route::delete('/', [AttributeValueController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('attribute-sets')->name('attribute-sets.')->group(function () {
                    Route::get('/', [AttributeSetController::class, 'index'])->name('index');
                    Route::post('/', [AttributeSetController::class, 'store'])->name('store');

                    Route::prefix('{attributeSet}')->name('single.')->group(function () {
                        Route::patch('/', [AttributeSetController::class, 'update'])->name('update');
                        Route::get('/', [AttributeSetController::class, 'show'])->name('show');
                        Route::delete('/', [AttributeSetController::class, 'destroy'])->name('destroy');
                        Route::post('/assign', [AttributeSetController::class, 'assignAttributes'])->name('assign-attributes');
                        Route::post('/unassign', [AttributeSetController::class, 'unassignAttributes'])->name('unassign-attributes');

                    });
                });

                Route::prefix('attribute-groups')->name('attribute-groups.')->group(function () {
                    Route::get('/', [AttributeGroupController::class, 'index'])->name('index');
                    Route::post('/', [AttributeGroupController::class, 'store'])->name('store');

                    Route::prefix('{attributeGroup}')->name('single.')->group(function () {
                        Route::patch('/', [AttributeGroupController::class, 'update'])->name('update');
                        Route::get('/', [AttributeGroupController::class, 'show'])->name('show');
                        Route::delete('/', [AttributeGroupController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('widgets')->name('widgets.')->group(function () {
                    Route::get('/', [WidgetController::class, 'index'])->name('index');
                    Route::post('/', [WidgetController::class, 'store'])->name('store');

                    Route::prefix('{widget:slug}')->name('single.')->group(function () {
                        Route::patch('/', [WidgetController::class, 'update'])->name('update');
                        Route::get('/', [WidgetController::class, 'show'])->name('show');
                        Route::delete('/', [WidgetController::class, 'destroy'])->name('destroy');
                        Route::post('/product/assign', [WidgetController::class, 'assignProducts'])->name('assign-products');
                        Route::post('/product/unassign', [WidgetController::class, 'unassignProducts'])->name('unassign-products');

                    });
                });

                Route::prefix('searches')->name('searches.')->group(function () {
                    Route::get('/', [SearchController::class, 'index'])->name('index');

                });

                Route::prefix('draft-products')->name('draft-products.')->group(function () {
                    Route::get('/', [DraftProductController::class, 'index'])->name('index');
                    Route::post('/', [DraftProductController::class, 'store'])->name('store');

                    Route::prefix('{draftProduct}')->name('single.')->group(function () {
                        Route::get('/', [DraftProductController::class, 'show'])->name('show');
                        Route::delete('/', [DraftProductController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('flat-products')->name('flat-products.')->group(function () {
                    Route::get('/', [FlatProductController::class, 'index'])->name('index');
                    Route::get('/sync', [FlatProductController::class, 'sync'])->name('sync');

                });
            });
        });
    });
});
