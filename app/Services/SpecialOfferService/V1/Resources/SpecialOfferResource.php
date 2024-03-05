<?php

namespace App\Services\SpecialOfferService\V1\Resources;

use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property mixed $id
 * @property string $name
 * @property string $slug
 * @property Collection $products
 * @property Carbon $available_from
 * @property Carbon $available_to
 * @property integer $product_id
 * @property Product $product
 */
class SpecialOfferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'product' => new ProductResource($this->product)
        ];
    }
}
