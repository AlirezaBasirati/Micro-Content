<?php

namespace App\Services\ProductService\V1\Repository\Admin\Brand;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandServiceInterface extends BaseRepositoryInterface
{
    public function getProducts($brand): LengthAwarePaginator;
}
