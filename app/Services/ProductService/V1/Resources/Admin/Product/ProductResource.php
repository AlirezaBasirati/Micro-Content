<?php

namespace App\Services\ProductService\V1\Resources\Admin\Product;

use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\ProductImage;
use App\Services\ProductService\V1\Resources\Admin\Brand\BrandResource;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer id
 * @property string name
 * @property string sku
 * @property string thumbnail
 * @property Brand brand
 * @property mixed $public_id
 * @property mixed $categories
 * @property mixed $status
 * @property mixed $type
 * @property mixed $url_key
 * @property mixed $tax_class
 * @property mixed $visibility
 */
class ProductResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'sku'        => $this->sku,
            'public_id'  => $this->public_id,
            'status'     => $this->status,
            'type'       => $this->type,
            'url_key'    => $this->url_key,
            'tax_class'  => $this->tax_class,
            'thumbnail'  => $thumbnail,
            'images'     => $images ?? [],
            'categories' => CategoryResource::collection($this->categories),
            'visibility' => $this->visibility,
            'brand'      => new BrandResource($this->brand),
        ];
    }
}
