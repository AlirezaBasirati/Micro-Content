<?php

namespace App\Services\ProductService\V1\Repository\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Database\Eloquent\Builder;
use Celysium\Base\Repository\BaseRepository;

class FlatProductServiceRepository extends BaseRepository implements FlatProductServiceInterface
{
    public function __construct(FlatProduct $model)
    {
        $model->setPerPage(20);
        parent::__construct($model);
    }

    public function query(Builder $query, array $parameters = []): Builder
    {
        $query->options(['allowDiskUse' => true]);

        if (isset($parameters['search'])) {
            $query->where(function ($query) use ($parameters) {
                $query->where('name', 'LIKE', $parameters['search'] . '%');
                $query->orWhere('sku', 'LIKE', '%' . $parameters['search'] . '%');
            });
        }

        if (isset($parameters['store_id'])) {
            if (!is_array($parameters['store_id'])) {
                $parameters['store_id'] = array($parameters['store_id']);
            }
            $storeIds = array_map(fn($store_id) => (int)$store_id, $parameters['store_id']);

            $query->whereIn('store_id', $storeIds);
        }

        return $query;
    }
}
