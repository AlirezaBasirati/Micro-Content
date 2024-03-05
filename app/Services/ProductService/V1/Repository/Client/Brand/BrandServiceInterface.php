<?php

namespace App\Services\ProductService\V1\Repository\Client\Brand;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandServiceInterface extends BaseRepositoryInterface
{
    public function getProducts($brand): LengthAwarePaginator;
}
