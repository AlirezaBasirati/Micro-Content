<?php

namespace App\Services\ProductService\V1\Resources\Admin\AttributeValue;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $value
 * @property mixed $attribute
 */
class AttributeValueDetailedResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->resource->id,
            'value'     => $this->resource->value,
            'image'     => $this->resource->image,
            'name'      => $this->resource->name,
            'attribute' => $this->resource->attribute->only(['id', 'title'])
        ];
    }
}
