<?php

namespace App\Services\ContentManagerService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Repository\Admin\ContactForm\ContactFormServiceInterface as ContactFormServiceRepository;
use App\Services\ContentManagerService\V1\Requests\Admin\ContactForm\CreateRequest;
use App\Services\ContentManagerService\V1\Resources\Admin\ContactForm\ContactFormResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class ContactFormController extends Controller
{
    private ContactFormServiceRepository $contactFormServiceRepository;

    public function __construct(ContactFormServiceRepository $contactFormServiceRepository)
    {
        $this->contactFormServiceRepository = $contactFormServiceRepository;
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $contactForm = $this->contactFormServiceRepository->store($request->validated());

        return Responser::created(new ContactFormResource($contactForm));
    }
}
