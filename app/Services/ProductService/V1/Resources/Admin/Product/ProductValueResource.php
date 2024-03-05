<?php

namespace App\Services\ProductService\V1\Resources\Admin\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer id
 * @property mixed $attribute_value_id
 * @property string $product_id
 * @property mixed $attribute_id
 */
class ProductValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'attribute_value_id' => $this->attribute_value_id,
            'attribute_id'       => $this->attribute_id,
            'product_id'         => $this->product_id,
        ];
    }
}
