<?php

namespace App\Services\ContentManagerService\V1\Repository\Admin\Newsletter;

use App\Services\ContentManagerService\V1\Models\Newsletter;
use Celysium\Base\Repository\BaseRepository;

class NewsletterServiceRepository extends BaseRepository implements NewsletterServiceInterface
{
    public function __construct(Newsletter $model)
    {
        parent::__construct($model);
    }
}
