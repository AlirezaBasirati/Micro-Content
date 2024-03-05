<?php

namespace App\Services\ContentManagerService\V1\Repository\Admin\SliderItem;

use App\Services\ContentManagerService\V1\Models\SliderItem;
use Celysium\Base\Repository\BaseRepository;

class SliderItemServiceRepository extends BaseRepository implements SliderItemServiceInterface
{
    public function __construct(protected SliderItem $sliderItem)
    {
        parent::__construct($this->sliderItem);
    }
}
