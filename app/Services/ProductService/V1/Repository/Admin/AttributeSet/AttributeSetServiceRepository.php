<?php

namespace App\Services\ProductService\V1\Repository\Admin\AttributeSet;

use App\Services\ProductService\V1\Models\AttributeSet;
use Celysium\Base\Repository\BaseRepository;

class AttributeSetServiceRepository extends BaseRepository implements AttributeSetServiceInterface
{
    public function __construct(protected AttributeSet $attributeSet)
    {
        parent::__construct($this->attributeSet);
    }

    public function assignAttributes(AttributeSet $attributeSet, array $attributeIds): AttributeSet
    {
        $attributeSet->attributes()->syncWithoutDetaching($attributeIds);

        return $attributeSet;
    }

    public function unassignAttributes(AttributeSet $attributeSet, array $attributeIds): AttributeSet
    {
        $attributeSet->attributes()->detach($attributeIds);

        return $attributeSet;
    }
}
