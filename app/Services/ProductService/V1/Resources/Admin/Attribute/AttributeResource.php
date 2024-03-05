<?php

namespace App\Services\ProductService\V1\Resources\Admin\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer id
 * @property string title
 * @property mixed $slug
 * @property mixed $type
 * @property mixed $searchable
 * @property mixed $filterable
 * @property mixed $comparable
 * @property mixed $visible
 * @property mixed $status
 * @property mixed $attribute_group_id
 */
class AttributeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'slug'               => $this->slug,
            'type'               => $this->type,
            'searchable'         => $this->searchable,
            'filterable'         => $this->filterable,
            'comparable'         => $this->comparable,
            'visible'            => $this->visible,
            'status'             => $this->status,
            'attribute_group_id' => $this->attribute_group_id,
        ];
    }
}
