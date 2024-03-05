<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\SliderPosition;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderPositionCollection extends ResourceCollection
{
    public $collects = SliderPositionResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
