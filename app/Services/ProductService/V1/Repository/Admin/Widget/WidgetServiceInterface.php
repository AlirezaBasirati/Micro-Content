<?php

namespace App\Services\ProductService\V1\Repository\Admin\Widget;

use App\Services\ProductService\V1\Models\Widget;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface WidgetServiceInterface extends BaseRepositoryInterface
{
    public function assignProducts(Widget $widget, array $productIds): Widget;

    public function unassignProducts(Widget $widget, array $productIds): Widget;

    public function assignViaExcel(Widget $widget, array $products): Widget;

    public function latestProducts(?array $categoryIds, string $take = '20'): array;

    public function mostViewedProducts(?array $categoryIds, string $take = '20'): array;

    public function bestSellerProducts(?array $categoryIds, string $take = '20'): array;

    public function incredibleProducts(?array $categoryIds, string $take = '20'): array;
}
