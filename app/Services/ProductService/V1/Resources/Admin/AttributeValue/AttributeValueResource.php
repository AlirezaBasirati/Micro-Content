<?php

namespace App\Services\ProductService\V1\Resources\Admin\AttributeValue;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer id
 * @property mixed $attribute_id
 * @property string $value
 * @property string $image
 * @property string $name
 */
class AttributeValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'attribute_id' => $this->attribute_id,
            'value'        => $this->value,
            'image'        => $this->image,
            'name'         => $this->name,
        ];
    }
}
