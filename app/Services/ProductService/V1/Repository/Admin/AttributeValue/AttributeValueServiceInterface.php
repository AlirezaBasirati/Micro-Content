<?php

namespace App\Services\ProductService\V1\Repository\Admin\AttributeValue;

use Illuminate\Database\Eloquent\Collection;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface AttributeValueServiceInterface extends BaseRepositoryInterface
{
    public function detail($parameters): Collection;

    public function groupByAttributes(array $attribute_values): array;

    public function getVariantProducts(array $attribute_values): array;

    public function isConfigurable(array $attribute_values): bool;

    public function productAttributes(array $attribute_values): array;
}
