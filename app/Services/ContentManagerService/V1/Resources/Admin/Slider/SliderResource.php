<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Slider;

use App\Services\ContentManagerService\V1\Resources\Admin\SliderItem\SliderItemCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $type
 * @property mixed $position_id
 * @property mixed $status
 * @property mixed $height
 * @property mixed $width
 */
class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'position_id' => $this->position_id,
            'status' => $this->status,
            'height' => $this->height,
            'width' => $this->width,
            'slider_items' => new SliderItemCollection($this->items)
        ];
    }
}
