<?php

namespace App\Services\ProductService\V1\Repository\Client\Category;

use App\Services\ProductService\V1\Models\Category;
use Illuminate\Support\Collection;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryServiceInterface extends BaseRepositoryInterface
{
    public function getProducts($category): LengthAwarePaginator;

    public function breadcrumb(Category $category): array;

    public function getChildren(int $categoryId): Collection;
}
