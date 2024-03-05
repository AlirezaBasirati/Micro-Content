<?php

namespace App\Services\ProductService\V1\Resources\Client\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string name
 * @property integer id
 * @property mixed $en_name
 * @property mixed $image
 * @property mixed $thumbnail
 * @property mixed $manufactured_in
 * @property mixed $status
 */
class BrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'en_name' => $this->en_name,
            'image' => $this->image,
            'thumbnail' => $this->thumbnail,
            'manufactured_in' => $this->manufactured_in,
            'status' => $this->status,
        ];
    }
}
