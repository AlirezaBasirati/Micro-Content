<?php

namespace App\Services\SpecialOfferService\V1\Repository;

use App\Services\ProductService\V1\Models\Product;
use App\Services\SpecialOfferService\V1\Models\SpecialOffer;
use Illuminate\Support\Arr;
use Celysium\Base\Repository\BaseRepository;

class SpecialOfferServiceRepository extends BaseRepository implements SpecialOfferServiceInterface
{
    public function __construct(SpecialOffer $model)
    {
        parent::__construct($model);
    }

    public function syncProducts(array $productIds): bool
    {
        if (!is_numeric(Arr::first($productIds))) {
            $productIds = Product::query()
                ->whereIn('sku', $productIds)
                ->pluck('id')
                ->toArray();
        }

        return true;
    }
}
