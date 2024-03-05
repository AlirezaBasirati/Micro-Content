<?php

namespace App\Services\ContentManagerService\V1\Repository\Admin\Faq;

use App\Services\ContentManagerService\V1\Models\Faq;
use Celysium\Base\Repository\BaseRepository;

class FaqServiceRepository extends BaseRepository implements FaqServiceInterface
{
    public function __construct(protected Faq $faq)
    {
        parent::__construct($this->faq);
    }
}
