<?php

namespace App\Providers;

use App\Events\ProductUpdate;
use App\Listeners\IncomingMessageListener;
use App\Listeners\UpdateFlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Observers\ProductObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Celysium\MessageBroker\Events\IncomingMessageEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ProductUpdate::class => [
            UpdateFlatProduct::class,
        ],
        IncomingMessageEvent::class => [
            IncomingMessageListener::class,
        ],
    ];

    protected $observers = [
        Product::class => [ProductObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
