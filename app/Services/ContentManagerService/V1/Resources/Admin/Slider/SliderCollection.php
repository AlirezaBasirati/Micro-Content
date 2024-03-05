<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Slider;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderCollection extends ResourceCollection
{
    public $collects = SliderResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
