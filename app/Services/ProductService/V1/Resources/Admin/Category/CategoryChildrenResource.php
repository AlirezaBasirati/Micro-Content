<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $children
 * @property mixed $icon
 * @property mixed $image
 * @property mixed $description
 * @property mixed $level
 * @property mixed $position
 * @property mixed $products
 * @property mixed $color
 */
class CategoryChildrenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'icon'           => $this->icon ?? null,
            'image'          => $this->image ?? null,
            'color'          => $this->color ?? null,
            'description'    => $this->description ?? null,
            'level'          => $this->level,
            'position'       => $this->position,
            'products_count' => count($this->products),
            'children'       => CategoryResource::collection($this->children),
        ];
    }
}
