<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Faq;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FaqCollection extends ResourceCollection
{
    public $collects = FaqResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
