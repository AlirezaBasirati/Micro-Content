<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class FlatProductBasicResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        /** @var FlatProduct $this */
        return [
            'store_id'           => $this->store_id,
            'id'                 => $this->id,
            'name'               => $this->name,
            'sku'                => $this->sku,
            'barcode'            => $this->barcode ?? null,
            'batch_id'           => $this->batch_id,
            'price_original'     => $this->price_original,
            'price_promoted'     => $this->price_promoted,
            'discounted_percent' => $this->discounted_percent,
            'gallery'            => $this->gallery,
            'thumbnail'          => $thumbnail,
        ];
    }
}
