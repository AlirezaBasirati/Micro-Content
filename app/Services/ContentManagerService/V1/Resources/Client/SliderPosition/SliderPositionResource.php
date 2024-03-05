<?php

namespace App\Services\ContentManagerService\V1\Resources\Client\SliderPosition;

use App\Services\ContentManagerService\V1\Models\Slider;
use App\Services\ContentManagerService\V1\Resources\Admin\Slider\SliderCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $slug
 * @property Slider $sliders
 */
class SliderPositionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'sliders' => new SliderCollection($this->sliders)
        ];
    }
}
