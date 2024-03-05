<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Newsletter;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsletterCollection extends ResourceCollection
{
    public $collects = NewsletterResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
