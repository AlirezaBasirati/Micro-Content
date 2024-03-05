<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\Brand;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @property mixed $store_id
 * @property integer id
 * @property string name
 * @property string sku
 * @property array $gallery
 * @property Brand brand
 * @property mixed $brand_id
 * @property mixed $type
 * @property mixed $max_in_cart
 * @property mixed $description
 * @property mixed $status
 * @property array $categories
 * @property mixed $quantity
 * @property mixed $is_in_stock
 * @property mixed $view_count
 * @property mixed $master_id
 * @property mixed $tax_class
 * @property mixed $visibility
 * @property mixed $barcode
 * @property mixed $color
 * @property mixed $dimensions
 * @property mixed $meta_title
 * @property mixed $meta_keyword
 * @property mixed $meta_description
 * @property mixed $merchant_id
 * @property mixed $merchant
 * @property mixed $price
 * @property mixed $bundle_quantity
 * @property mixed $price_original
 * @property mixed $price_promoted
 */
class FlatProductBundleResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        $category = Arr::last($this->categories);

        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributes[$attribute['slug']] = $attribute;
        }

        return [
            'store_id'         => $this->store_id,
            'merchant_id'      => $this->merchant_id,
            'merchant'         => $this->merchant,
            'id'               => $this->id,
            'type'             => $this->type,
            'name'             => $this->name,
            'sku'              => $this->sku,
            'price'            => $this->price,
            'price_original'   => $this->price_original,
            'price_promoted'   => $this->price_promoted,
            'max_in_cart'      => $this->max_in_cart ? min($this->max_in_cart, $this->quantity) : $this->quantity,
            'is_in_stock'      => $this->is_in_stock,
            'quantity'         => $this->quantity,
            'bundle_quantity'  => $this->bundle_quantity,
            'description'      => $this->description,
            'status'           => $this->status,
            'gallery'          => $this->gallery,
            'thumbnail'        => $thumbnail,
            'tax_class'        => $this->tax_class,
            'visibility'       => $this->visibility,
            'barcode'          => $this->barcode ?? null,
            'color'            => $this->color ?? null,
            'dimensions'       => $this->dimensions ?? null,
            'meta_title'       => $this->meta_title ?? null,
            'meta_keyword'     => $this->meta_keyword ?? null,
            'meta_description' => $this->meta_description ?? null,
            'brand_name'       => $this->brand->name ?? null,
            'brand_id'         => $this->brand->id ?? null,
            'view_count'       => $this->view_count,
            'category'         => $category,
            'attributes'       => $attributes,
        ];
    }
}
