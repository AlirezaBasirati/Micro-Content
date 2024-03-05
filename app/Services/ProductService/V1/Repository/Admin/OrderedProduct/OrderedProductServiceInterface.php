<?php

namespace App\Services\ProductService\V1\Repository\Admin\OrderedProduct;

use Celysium\Base\Repository\BaseRepositoryInterface;

interface OrderedProductServiceInterface extends BaseRepositoryInterface
{
    public function orderedProducts(array $parameters): void;
}
