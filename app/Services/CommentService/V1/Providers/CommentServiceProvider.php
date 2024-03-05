<?php

namespace App\Services\CommentService\V1\Providers;

use App\Services\CommentService\V1\Repositories\Admin\Comment\CommentServiceInterface as CommentServiceInterfaceAdmin;
use App\Services\CommentService\V1\Repositories\Admin\Comment\CommentServiceRepository as CommentServiceRepositoryAdmin;
use App\Services\CommentService\V1\Repositories\Client\Comment\CommentServiceInterface;
use App\Services\CommentService\V1\Repositories\Client\Comment\CommentServiceRepository;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CommentServiceInterfaceAdmin::class, CommentServiceRepositoryAdmin::class);
        $this->app->bind(CommentServiceInterface::class, CommentServiceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/client.php');
    }
}
