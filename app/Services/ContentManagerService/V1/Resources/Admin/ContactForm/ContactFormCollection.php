<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\ContactForm;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactFormCollection extends ResourceCollection
{
    public $collects = ContactFormResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
