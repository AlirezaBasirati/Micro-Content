<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use function last;

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
 * @property mixed $parent
 */
class CategorySidebarResource extends JsonResource
{
    public function toArray($request)
    {
        if (last($request->get('category_ids')) == $this->id) {
            return [
                'id'       => $this->id,
                'title'    => $this->title,
                'children' => CategorySidebarResource::collection($this->children),
            ];
        }
        return [
            'id'    => $this->id,
            'title' => $this->title,
        ];
    }
}
