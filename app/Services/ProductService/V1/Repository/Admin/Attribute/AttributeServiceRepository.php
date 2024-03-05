<?php

namespace App\Services\ProductService\V1\Repository\Admin\Attribute;

use App\Services\ProductService\V1\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Celysium\Base\Repository\BaseRepository;

class AttributeServiceRepository extends BaseRepository implements AttributeServiceInterface
{
    public function __construct(Attribute $model)
    {
        parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'is_active'   => fn($value) => $query->where('status', 1),
            'is_featured' => fn($value) => $query->where('is_featured', 1),
            'search'      => fn($value) => $query->where(function ($query) use ($value) {
                $query->where('title', 'LIKE', '%' . $value . '%');
                $query->orWhere('slug', 'LIKE', '%' . $value . '%');
            }),
        ];
    }
}
