<?php

namespace App\Services\ProductService\V1\Repository\Admin\DraftProduct;

use App\Services\ProductService\V1\Models\DraftProduct;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class DraftProductServiceRepository extends BaseRepository implements DraftProductServiceInterface
{
    #[Pure] public function __construct(DraftProduct $model)
    {
        parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'search' => fn($value) => $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
                $query->orWhere('sku', 'LIKE', '%' . $value . '%');
            }),
        ];
    }

    public function store(array $parameters): Model
    {
        return DraftProduct::query()->create([
            'sku'  => $parameters['articleNumber'],
            'name' => $parameters['articleDescription'],
        ]);
    }
}
