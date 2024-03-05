<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class FlatProductAdminResource extends JsonResource
{
    public function toArray($request): array
    {
        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        /** @var FlatProduct $this */
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'sku'            => $this->sku,
            'quantity'       => $this->quantity,
            'barcode'        => $this->barcode ?? null,
            'price_original' => $this->price_original,
            'price_promoted' => $this->price_promoted,
            'gallery'        => $this->gallery,
            'thumbnail'      => $thumbnail,
            'status'         => $this->status,
        ];
    }
}
