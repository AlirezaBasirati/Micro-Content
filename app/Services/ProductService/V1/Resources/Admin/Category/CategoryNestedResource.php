<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $children
 * @property mixed $icon
 * @property mixed $image
 */
class CategoryNestedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'icon'     => $this->icon ?? null,
            'image'    => $this->image ?? null,
            'children' => CategoryNestedResource::collection($this->children),
        ];
    }
}
