<?php

namespace App\Services\ContentManagerService\V1\Repository\Admin\Slider;

use App\Services\ContentManagerService\V1\Models\Slider;
use Celysium\Base\Repository\BaseRepository;

class SliderServiceRepository extends BaseRepository implements SliderServiceInterface
{
    public function __construct(protected Slider $slider)
    {
        parent::__construct($this->slider);
    }
}
