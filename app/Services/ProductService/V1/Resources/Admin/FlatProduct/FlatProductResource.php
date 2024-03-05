<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $gallery
 * @property mixed $attributes
 */
class FlatProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributes[$attribute['slug']] = $attribute;
        }
        $master = null;
        if($this->master_id) {
            $master = FlatProduct::query()->where('id', $this->master_id)->first();
        }
        /** @var FlatProduct $this */
        return [
            'store_id'           => $this->store_id,
            'merchant_id'        => $this->merchant_id,
            'id'                 => $this->id,
            'type'               => $this->type,
            'name'               => $this->name,
            'sku'                => $this->sku,
            'batch_id'           => $this->batch_id,
            'price_original'     => $this->price_original,
            'price_promoted'     => $this->price_promoted,
            'discounted_percent' => $this->discounted_percent,
            'max_in_cart'        => $this->max_in_cart,
            'min_in_cart'        => $this->min_in_cart,
            'is_in_stock'        => $this->is_in_stock,
            'quantity'           => $this->quantity,
            'description'        => $this->description,
            'status'             => $this->status,
            'barcode'            => $this->barcode ?? null,
            'gallery'            => $this->gallery,
            'thumbnail'          => $thumbnail,
            'attributes'         => $attributes,
            'master'             => $master ? new FlatProductResource($master) : null,
            'brand'              => $this->brand,
            'brand_id'           => $this->brand_id,
            'view_count'         => $this->view_count,
            'category_ids'       => $this->categories,
            //            'related_products'   => FlatProductExcerptResource::collection($relatedProducts),
        ];
    }
}

