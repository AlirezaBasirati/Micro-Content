<?php

namespace App\Services\CampaignService\V1\Providers;

use App\Services\CampaignService\V1\Repository\CampaignServiceInterface;
use App\Services\CampaignService\V1\Repository\CampaignServiceRepository;
use Illuminate\Support\ServiceProvider;

class CampaignServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CampaignServiceInterface::class, CampaignServiceRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
