<?php

namespace App\Services\ProductService\V1\Resources\Admin\Product;

use App\Services\ProductService\V1\Models\ProductImage;
use App\Services\ProductService\V1\Resources\Admin\Brand\BrandResource;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $status
 * @property mixed $name
 * @property mixed $sku
 * @property mixed $description
 * @property mixed $brand
 * @property mixed $categories
 * @property mixed $image
 * @property mixed $productValues
 * @property mixed $subProducts
 * @property mixed $children
 * @property mixed $public_id
 * @property mixed $type
 * @property mixed $url_key
 * @property mixed $tax_class
 * @property mixed $visibility
 */
class ProductDetailedResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = ProductImage::query()
            ->where('product_id', $this->id)
            ->where('is_thumbnail', 1)->first()?->url;

        $images = ProductImage::query()
            ->where('product_id', $this->id)
            ->where('is_thumbnail', 0)->pluck('url');

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'public_id'   => $this->public_id,
            'sku'         => $this->sku,
            'description' => $this->description,
            'status'      => $this->status,
            'type'        => $this->type,
            'url_key'     => $this->url_key,
            'tax_class'   => $this->tax_class,
            'visibility'  => $this->visibility,
            'images'      => $images ?? [],
            'thumbnail'   => $thumbnail,
            'categories' => CategoryResource::collection($this->categories),
            'brand'       => new BrandResource($this->brand),
            'attributes'  => ProductValueResource::collection($this->productValues),
            //            'sub_products' => ProductDetailedResource::collection($this->subProducts),
            //            'bundles'       => ProductDetailedResource::collection($this->bundles),
        ];
    }
}
