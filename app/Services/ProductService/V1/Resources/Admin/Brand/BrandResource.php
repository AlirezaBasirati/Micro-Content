<?php

namespace App\Services\ProductService\V1\Resources\Admin\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
