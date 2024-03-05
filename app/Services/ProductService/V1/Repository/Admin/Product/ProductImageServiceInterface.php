<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use App\Services\ProductService\V1\Models\Product;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface ProductImageServiceInterface extends BaseRepositoryInterface
{
    public function addFile($product, $media, $position): void;

    public function removeFile($product, $productImage): string;

    public function addImages(Product $product, array $parameters): void;
}
