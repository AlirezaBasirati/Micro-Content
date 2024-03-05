<?php

namespace App\Services\ProductService\V1\Repository\Admin\AttributeGroup;

use App\Services\ProductService\V1\Models\AttributeGroup;
use Celysium\Base\Repository\BaseRepository;

class AttributeGroupServiceRepository extends BaseRepository implements AttributeGroupServiceInterface
{
    public function __construct(AttributeGroup $model)
    {
        parent::__construct($model);
    }
}
