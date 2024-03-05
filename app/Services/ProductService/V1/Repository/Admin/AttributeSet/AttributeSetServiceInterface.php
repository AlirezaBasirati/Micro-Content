<?php

namespace App\Services\ProductService\V1\Repository\Admin\AttributeSet;

use App\Services\ProductService\V1\Models\AttributeSet;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface AttributeSetServiceInterface extends BaseRepositoryInterface
{
    public function assignAttributes(AttributeSet $attributeSet, array $attributeIds): AttributeSet;

    public function unassignAttributes(AttributeSet $attributeSet, array $attributeIds): AttributeSet;
}
