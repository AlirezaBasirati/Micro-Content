<?php

namespace App\Services\ProductService\V1\Repository\Admin\FlatBrand;

use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\FlatCategoryBrand;
use Illuminate\Database\Eloquent\Builder;
use Celysium\Base\Repository\BaseRepository;

class FlatBrandServiceRepository extends BaseRepository implements FlatBrandServiceInterface
{
    public function __construct(FlatCategoryBrand $model)
    {
        parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'category_ids' => fn($value) => $query->whereIn('category_id', $value),

            'search' => fn($value) => $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
                $query->orWhere('sku', 'LIKE', '%' . $value . '%');
            }),

        ];
    }

    public function query(Builder $query, array $parameters = []): Builder
    {
        if (isset($parameters['categories'])) {
            $parameters['category_ids'] = Category::query()->whereIn('slug', $parameters['categories'])->pluck('id')->toArray();
            if (count($parameters['category_ids']) == 0) {
                unset($parameters['category_ids']);
            }
        }
        return $query;
    }
}
