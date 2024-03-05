<?php

namespace App\Services\ContentManagerService\V1\Repository\Client\SliderPosition;

use App\Services\ContentManagerService\V1\Models\SliderPosition;
use Celysium\Base\Repository\BaseRepository;

class SliderPositionServiceRepository extends BaseRepository implements SliderPositionServiceInterface
{
    public function __construct(protected SliderPosition $sliderPosition)
    {
        parent::__construct($this->sliderPosition);
    }
}
