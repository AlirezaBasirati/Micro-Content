<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Newsletter;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $email
 * @property mixed $source
 */
class NewsletterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'source' => $this->source,
        ];
    }
}
