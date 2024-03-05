<?php

namespace App\Services\ProductService\V1\Resources\Admin\AttributeSet;

use App\Services\ProductService\V1\Models\Attribute;
use App\Services\ProductService\V1\Resources\Admin\Attribute\AttributeResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string title
 * @property integer id
 * @property mixed $status
 * @property Attribute $attributes
 */
class AttributeSetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'status'     => $this->status,
            'attributes' => AttributeResource::collection($this->attributes),
        ];
    }
}
