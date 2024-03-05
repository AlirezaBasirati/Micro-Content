<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\SliderItem;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderItemCollection extends ResourceCollection
{
    public $collects = SliderItemResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
