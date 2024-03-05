<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\SliderItem;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $url
 * @property mixed $status
 * @property mixed $image_url
 * @property mixed $slider_id
 */
class SliderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'url'       => $this->url,
            'status'    => $this->status,
            'image_url' => $this->image_url,
            'slider_id' => $this->slider_id
        ];
    }
}
