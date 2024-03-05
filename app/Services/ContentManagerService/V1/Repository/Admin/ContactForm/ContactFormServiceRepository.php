<?php

namespace App\Services\ContentManagerService\V1\Repository\Admin\ContactForm;

use App\Services\ContentManagerService\V1\Models\ContactForm;
use Celysium\Base\Repository\BaseRepository;

class ContactFormServiceRepository extends BaseRepository implements ContactFormServiceInterface
{
    public function __construct(protected ContactForm $contactForm)
    {
        parent::__construct($this->contactForm);
    }
}
