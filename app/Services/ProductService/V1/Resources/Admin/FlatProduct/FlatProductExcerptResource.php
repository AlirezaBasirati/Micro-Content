<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $gallery
 */
class FlatProductExcerptResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        /** @var FlatProduct $this */
        return [
            'store_id'           => $this->store_id,
            'merchant_id'        => $this->merchant_id,
            'id'                 => $this->id,
            'type'               => $this->type,
            'name'               => $this->name,
            'batch_id'           => $this->batch_id,
            'sku'                => $this->sku,
            'barcode'            => $this->barcode ?? null,
            'price_original'     => $this->price_original,
            'price_promoted'     => $this->price_promoted,
            'discounted_percent' => $this->discounted_percent,
            'max_in_cart'        => $this->max_in_cart ? min($this->max_in_cart, $this->quantity) : $this->quantity,
            'is_in_stock'        => $this->is_in_stock,
            'quantity'           => $this->quantity,
            'status'             => $this->status,
            'gallery'            => $this->gallery,
            'thumbnail'          => $thumbnail,
            'brand_name'         => $this->brand_name,
            'brand_id'           => $this->brand_id,
        ];
    }
}
