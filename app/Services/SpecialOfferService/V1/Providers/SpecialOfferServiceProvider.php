<?php

namespace App\Services\SpecialOfferService\V1\Providers;

use App\Services\SpecialOfferService\V1\Repository\SpecialOfferServiceInterface;
use App\Services\SpecialOfferService\V1\Repository\SpecialOfferServiceRepository;
use Illuminate\Support\ServiceProvider;

class SpecialOfferServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SpecialOfferServiceInterface::class, SpecialOfferServiceRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
