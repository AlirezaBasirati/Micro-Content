<?php

namespace App\Services\FavoriteService\V1\Providers;

use App\Services\FavoriteService\V1\Repositories\Client\Favorite\FavoriteServiceInterface;
use App\Services\FavoriteService\V1\Repositories\Client\Favorite\FavoriteServiceRepository;
use Illuminate\Support\ServiceProvider;

class FavoriteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(FavoriteServiceInterface::class, FavoriteServiceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/client.php');
    }
}
