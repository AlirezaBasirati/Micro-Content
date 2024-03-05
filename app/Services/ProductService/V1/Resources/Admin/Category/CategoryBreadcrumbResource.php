<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $id
 * @property mixed $parent_id
 * @property mixed $level
 * @property mixed $children
 */
class CategoryBreadcrumbResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'parent_id' => $this->parent_id,
            'level'     => $this->level,
            'title'     => $this->title,
            'slug'      => $this->slug,
            'children'  => CategoryResource::collection($this->children),
        ];
    }
}
