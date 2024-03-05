<?php

namespace App\Services\ProductService\V1\Repository\Admin\Widget;

use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\OrderedProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\Widget;
use App\Services\SpecialOfferService\V1\Models\SpecialOffer;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\Pure;

class WidgetServiceRepository extends BaseRepository implements WidgetServiceInterface
{
    #[Pure] public function __construct(Widget $model)
    {
        parent::__construct($model);
    }

    public function assignProducts(Widget $widget, array $productIds): Widget
    {
        if (!is_numeric(Arr::first($productIds))) {
            $productIds = Product::query()
                ->whereIn('sku', $productIds)
                ->pluck('id')
                ->toArray();
        }
        $widget->products()->sync($productIds);

        return $widget;
    }

    public function unassignProducts(Widget $widget, array $productIds): Widget
    {
        $widget->products()->detach($productIds);

        return $widget;
    }

    public function assignViaExcel(Widget $widget, array $products): Widget
    {
        foreach ($products as $product) {
            /** @var Product $productId */
            $productId = Product::query()
                ->where('sku', $product['sku'])
                ->first(['id']);

            $widget->products()->syncWithoutDetaching([$productId->id => ['start_date' => $product['start_date'], 'end_date' => $product['end_date']]]);
        }
        return $widget;
    }

    public function mostViewedProducts(?array $categoryIds, string $take = '20'): array
    {
        $flatProductsQuery = FlatProduct::query()
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE)
            ->where('price_original', '>', 0);

        if ($categoryIds) {
            $flatProductsQuery->whereIn('categories.id', $categoryIds);
        }

        return $flatProductsQuery
            ->orderByDesc('is_in_stock')
            ->orderByDesc('view_count')
            ->take($take)
            ->pluck('sku')
            ->toArray();
    }

    public function latestProducts(?array $categoryIds, string $take = '20'): array
    {
        $flatProductsQuery = FlatProduct::query()
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE)
            ->where('price_original', '>', 0);

        if ($categoryIds) {
            $flatProductsQuery->whereIn('categories.id', $categoryIds);
        }

        return $flatProductsQuery
            ->orderByDesc('is_in_stock')
            ->orderByDesc('created_at')
            ->take($take)
            ->pluck('sku')
            ->toArray();
    }

    public function bestSellerProducts(?array $categoryIds, string $take = '20'): array
    {
        $orderedProductsQuery = OrderedProduct::query()
            ->join('products', 'products.id', 'ordered_products.product_id')
            ->where('products.status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE);

        if ($categoryIds) {
            $orderedProductsQuery = $orderedProductsQuery->whereHas('product.categories', function (Builder $query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            });
        }

        return $orderedProductsQuery
            ->orderByDesc('ordered_quantity')
            ->take($take)
            ->pluck('products.id')
            ->toArray();
    }

    public function incredibleProducts(?array $categoryIds, string $take = '20'): array
    {
        $flatProductsQuery = FlatProduct::query()
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE)
            ->where('price_original', '>', 0);

        if ($categoryIds) {
            $flatProductsQuery->whereIn('categories.id', $categoryIds);
        }

        $specialOfferProductIds = SpecialOffer::query()->available()->pluck('product_id');
        $flatProductsQuery->whereIn('id', $specialOfferProductIds);

        return $flatProductsQuery
            ->orderByDesc('is_in_stock')
            ->take($take)
            ->pluck('sku')
            ->toArray();
    }
}
