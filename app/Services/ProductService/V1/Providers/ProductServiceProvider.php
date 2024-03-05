<?php

namespace App\Services\ProductService\V1\Providers;

use App\Services\ProductService\V1\Commands\BestSellerWidget;
use App\Services\ProductService\V1\Commands\CreateAllWidgets;
use App\Services\ProductService\V1\Commands\EditImageUrl;
use App\Services\ProductService\V1\Commands\EditStock;
use App\Services\ProductService\V1\Commands\FillCategoryImages;
use App\Services\ProductService\V1\Commands\FillFlatProduct;
use App\Services\ProductService\V1\Commands\FillPriceFlatProduct;
use App\Services\ProductService\V1\Commands\FillProductCategories;
use App\Services\ProductService\V1\Commands\IncredibleWidget;
use App\Services\ProductService\V1\Commands\LatestWidget;
use App\Services\ProductService\V1\Commands\MostViewedWidget;
use App\Services\ProductService\V1\Commands\SyncFlatProduct;
use App\Services\ProductService\V1\Commands\UpdateFlatProduct;
use App\Services\ProductService\V1\Repository\Admin\Attribute\AttributeServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Attribute\AttributeServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\AttributeGroup\AttributeGroupServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\AttributeGroup\AttributeGroupServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\AttributeSet\AttributeSetServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\AttributeSet\AttributeSetServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\AttributeValue\AttributeValueServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\AttributeValue\AttributeValueServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Brand\BrandServiceInterface as AdminBrandServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Brand\BrandServiceRepository as AdminBrandServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Category\CategoryServiceInterface as AdminCategoryServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Category\CategoryServiceRepository as AdminCategoryServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\DraftProduct\DraftProductServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\DraftProduct\DraftProductServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\FlatBrand\FlatBrandServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\FlatBrand\FlatBrandServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface as AdminFlatProductServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceRepository as AdminFlatProductServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\OrderedProduct\OrderedProductServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\OrderedProduct\OrderedProductServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductImageServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductImageServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductValueServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductValueServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Search\SearchServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Search\SearchServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\Widget\WidgetServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Widget\WidgetServiceRepository;
use App\Services\ProductService\V1\Repository\Client\Brand\BrandServiceInterface as ClientBrandServiceInterface;
use App\Services\ProductService\V1\Repository\Client\Brand\BrandServiceRepository as ClientBrandServiceRepository;
use App\Services\ProductService\V1\Repository\Client\Category\CategoryServiceInterface as ClientCategoryServiceInterface;
use App\Services\ProductService\V1\Repository\Client\Category\CategoryServiceRepository as ClientCategoryServiceRepository;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceInterface as ClientFlatProductServiceInterface;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceRepository as ClientFlatProductServiceRepository;
use App\Services\ProductService\V1\Repository\External\Product\ProductServiceInterface as ExternalProductServiceInterface;
use App\Services\ProductService\V1\Repository\External\Product\ProductServiceRepository as ExternalProductServiceRepository;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AttributeServiceInterface::class, AttributeServiceRepository::class);
        $this->app->bind(AttributeGroupServiceInterface::class, AttributeGroupServiceRepository::class);
        $this->app->bind(AttributeSetServiceInterface::class, AttributeSetServiceRepository::class);
        $this->app->bind(AttributeValueServiceInterface::class, AttributeValueServiceRepository::class);
        $this->app->bind(AdminBrandServiceInterface::class, AdminBrandServiceRepository::class);
        $this->app->bind(ClientBrandServiceInterface::class, ClientBrandServiceRepository::class);
        $this->app->bind(AdminCategoryServiceInterface::class, AdminCategoryServiceRepository::class);
        $this->app->bind(ClientCategoryServiceInterface::class, ClientCategoryServiceRepository::class);
        $this->app->bind(DraftProductServiceInterface::class, DraftProductServiceRepository::class);
        $this->app->bind(FlatBrandServiceInterface::class, FlatBrandServiceRepository::class);
        $this->app->bind(AdminFlatProductServiceInterface::class, AdminFlatProductServiceRepository::class);
        $this->app->bind(ClientFlatProductServiceInterface::class, ClientFlatProductServiceRepository::class);
        $this->app->bind(OrderedProductServiceInterface::class, OrderedProductServiceRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductServiceRepository::class);
        $this->app->bind(ProductImageServiceInterface::class, ProductImageServiceRepository::class);
        $this->app->bind(ProductValueServiceInterface::class, ProductValueServiceRepository::class);
        $this->app->bind(WidgetServiceInterface::class, WidgetServiceRepository::class);
        $this->app->bind(SearchServiceInterface::class, SearchServiceRepository::class);

        $this->app->bind(ExternalProductServiceInterface::class, ExternalProductServiceRepository::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                FillFlatProduct::class,
                FillPriceFlatProduct::class,
                LatestWidget::class,
                MostViewedWidget::class,
                BestSellerWidget::class,
                IncredibleWidget::class,
                CreateAllWidgets::class,
                FillCategoryImages::class,
                FillProductCategories::class,
                EditImageUrl::class,
                EditStock::class,
                UpdateFlatProduct::class,
            ]);
        }

        $this->commands([
            SyncFlatProduct::class,
        ]);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/client.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/internal.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/external.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
