<?php

namespace App\Services\ProductService\V1\Repository\Client\Brand;

use App\Services\ProductService\V1\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Celysium\Base\Repository\BaseRepository;
use JetBrains\PhpStorm\Pure;

class BrandServiceRepository extends BaseRepository implements BrandServiceInterface
{
    #[Pure] public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'is_active'   => fn($value) => $query->where('status', 1),
            'is_featured' => fn($value) => $query->where('is_featured', 1),
            'search'      => fn($value) => $query->where('name', 'LIKE', '%' . $value . '%')
        ];
    }

    public function getProducts($brand): LengthAwarePaginator
    {
        return $brand->products()->paginate(16);
    }
}
