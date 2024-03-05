<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use Celysium\Base\Repository\BaseRepositoryInterface;

interface ProductValueServiceInterface extends BaseRepositoryInterface
{
    public function storeMany(array $parameters): void;
}
