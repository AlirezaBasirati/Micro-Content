<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\Product;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface ProductServiceInterface extends BaseRepositoryInterface
{
    public function listWithCategories(array $productIds): Collection;

    public function extendedCreate($parameters): Product;

    public function extendedUpdate(Product $product, $parameters): Product;

    public function assignAttribute(Product $product, AttributeValue $attributeValue): Product;

    public function unassignAttribute(Product $product, AttributeValue $attributeValue): Product;

    public function assignCategories(Product $product, array $categoryIds, $detaching): Product;

    public function unassignCategories(Product $product, array $categoryIds): Product;

    public function addConfigurable(Product $product, array $productIds): Product;

    public function removeConfigurable(Product $product, array $productIds): Product;

    public function addBundles(Product $product, array $parameters): Product;

    public function removeBundles(Product $product, array $productIds): Product;

    public function addRelated(Product $product, array $productIds): Product;

    public function removeRelated(Product $product, array $productIds): Product;

    public function bulkUpdate(array $parameters): void;

    public function bulkProductCategoryAssign(array $parameters): int;
}
