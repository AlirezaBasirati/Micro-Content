<?php

namespace App\Services\ContentManagerService\V1\Providers;

use App\Services\ContentManagerService\V1\Repository\Admin\ContactForm\ContactFormServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\ContactForm\ContactFormServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Admin\Faq\FaqServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\Faq\FaqServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Admin\Newsletter\NewsletterServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\Newsletter\NewsletterServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Admin\Slider\SliderServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\Slider\SliderServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderItem\SliderItemServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderItem\SliderItemServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderPosition\SliderPositionServiceInterface as AdminSliderPositionServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderPosition\SliderPositionServiceRepository as AdminSliderPositionServiceRepository;
use App\Services\ContentManagerService\V1\Repository\Client\SliderPosition\SliderPositionServiceInterface as ClientSliderPositionServiceInterface;
use App\Services\ContentManagerService\V1\Repository\Client\SliderPosition\SliderPositionServiceRepository as ClientSliderPositionServiceRepository;
use Illuminate\Support\ServiceProvider;

class ContentManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SliderServiceInterface::class, SliderServiceRepository::class);
        $this->app->bind(AdminSliderPositionServiceInterface::class, AdminSliderPositionServiceRepository::class);
        $this->app->bind(ClientSliderPositionServiceInterface::class, ClientSliderPositionServiceRepository::class);
        $this->app->bind(SliderItemServiceInterface::class, SliderItemServiceRepository::class);
        $this->app->bind(FaqServiceInterface::class, FaqServiceRepository::class);
        $this->app->bind(ContactFormServiceInterface::class, ContactFormServiceRepository::class);
        $this->app->bind(NewsletterServiceInterface::class, NewsletterServiceRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/client.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
