<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductImage;
use Celysium\Base\Repository\BaseRepository;
use JetBrains\PhpStorm\Pure;

class ProductImageServiceRepository extends BaseRepository implements ProductImageServiceInterface
{
    #[Pure] public function __construct(ProductImage $model)
    {
        parent::__construct($model);
    }

    public function addFile($product, $media, $position): void
    {
        $product->images()->create(['url' => $media, 'position' => $position]);
    }

    public function removeFile($product, $productImage): string
    {
        if ($product->id == $productImage->product_id) {
            $productImage->delete();
            return 'deleted';
        } else
            return 'not deleted';
    }

    public function addImages(Product $product, array $parameters): void
    {
        $product->images()->delete();
        foreach ($parameters as $parameter) {
            $product->images()->create(['url' => $parameter]);
        }
    }
}
