<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use App\Services\ProductService\V1\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        /** @var Category $this */
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'position'    => $this->position,
            'slug'        => $this->slug,
            'description' => $this->description,
            'image'       => $this->image,
            'icon'        => $this->icon,
            'level'       => $this->level,
            'parent_id'   => $this->parent_id,
            'status'      => $this->status,
            'path'        => $this->path,
        ];
    }
}
