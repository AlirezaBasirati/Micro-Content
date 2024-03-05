<?php

namespace App\Services\ProductService\V1\Resources\Admin\AttributeGroup;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer id
 * @property mixed $name
 * @property mixed $slug
 */
class AttributeGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
