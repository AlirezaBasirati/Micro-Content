<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\ContactForm;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $topic
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $description
 */
class ContactFormResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'topic' => $this->topic,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => $this->description,
        ];
    }
}
