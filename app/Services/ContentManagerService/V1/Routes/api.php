<?php

use App\Services\ContentManagerService\V1\Controllers\Admin\ContactFormController;
use App\Services\ContentManagerService\V1\Controllers\Admin\FaqController;
use App\Services\ContentManagerService\V1\Controllers\Admin\NewsletterController;
use App\Services\ContentManagerService\V1\Controllers\Admin\SliderController;
use App\Services\ContentManagerService\V1\Controllers\Admin\SliderItemController;
use App\Services\ContentManagerService\V1\Controllers\Admin\SliderPositionController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('authenticate')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {
                Route::prefix('contact-forms')->name('contact-forms.')->group(function () {
                    Route::get('/', [ContactFormController::class, 'index'])->name('index');

                    Route::prefix('{contactForm}')->name('single.')->group(function () {
                        Route::get('/', [ContactFormController::class, 'show'])->name('show');
                        Route::delete('/', [ContactFormController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('faqs')->name('faqs.')->group(function () {
                    Route::get('/', [FaqController::class, 'index'])->name('index');
                    Route::post('/', [FaqController::class, 'store'])->name('store');

                    Route::prefix('{faq}')->name('single.')->group(function () {
                        Route::patch('/', [FaqController::class, 'update'])->name('update');
                        Route::get('/', [FaqController::class, 'show'])->name('show');
                        Route::delete('/', [FaqController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('slider-positions')->name('slider-positions.')->group(function () {
                    Route::get('/', [SliderPositionController::class, 'index'])->name('index');
                    Route::post('/', [SliderPositionController::class, 'store'])->name('store');

                    Route::prefix('{sliderPosition}')->name('single.')->group(function () {
                        Route::patch('/', [SliderPositionController::class, 'update'])->name('update');
                        Route::get('/', [SliderPositionController::class, 'show'])->name('show');
                        Route::delete('/', [SliderPositionController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('sliders')->name('sliders.')->group(function () {
                    Route::get('/', [SliderController::class, 'index'])->name('index');
                    Route::post('/', [SliderController::class, 'store'])->name('store');

                    Route::prefix('{slider}')->name('single.')->group(function () {
                        Route::patch('/', [SliderController::class, 'update'])->name('update');
                        Route::get('/', [SliderController::class, 'show'])->name('show');
                        Route::delete('/', [SliderController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('slider-items')->name('slider-items.')->group(function () {
                    Route::get('/', [SliderItemController::class, 'index'])->name('index');
                    Route::post('/', [SliderItemController::class, 'store'])->name('store');

                    Route::prefix('{sliderItem}')->name('single.')->group(function () {
                        Route::post('/', [SliderItemController::class, 'update'])->name('update');
                        Route::get('/', [SliderItemController::class, 'show'])->name('show');
                        Route::delete('/', [SliderItemController::class, 'destroy'])->name('destroy');

                    });
                });

                Route::prefix('newsletters')->name('newsletters.')->group(function () {
                    Route::get('/', [NewsletterController::class, 'index'])->name('index');
                    Route::post('/', [NewsletterController::class, 'store'])->name('store');

                    Route::prefix('{newsletter}')->name('single.')->group(function () {
                        Route::get('/', [NewsletterController::class, 'show'])->name('show');
                        Route::delete('/', [NewsletterController::class, 'destroy'])->name('destroy');

                    });
                });
            });
        });

        Route::prefix('app')->name('client.')->group(function () {
            Route::prefix('v1')->name('v1.')->group(function () {
                Route::prefix('contact-forms')->name('contact-forms.')->group(function () {
                    Route::post('/', [ContactFormController::class, 'store'])->name('store');

                });

                Route::prefix('slider-positions')->name('slider-positions.')->group(function () {
                    Route::get('/', [SliderPositionController::class, 'index'])->name('index');

                    Route::prefix('{sliderPosition}')->name('single.')->group(function () {
                        Route::get('/', [SliderPositionController::class, 'show'])->name('show');

                    });
                });
            });
        });
    });
});

