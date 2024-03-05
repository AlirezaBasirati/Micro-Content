<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\ContactForm;
use App\Services\ContentManagerService\V1\Repository\Admin\ContactForm\ContactFormServiceInterface as ContactFormServiceRepository;
use App\Services\ContentManagerService\V1\Resources\Admin\ContactForm\ContactFormCollection;
use App\Services\ContentManagerService\V1\Resources\Admin\ContactForm\ContactFormResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    private ContactFormServiceRepository $contactFormServiceRepository;

    public function __construct(ContactFormServiceRepository $contactFormServiceRepository)
    {
        $this->contactFormServiceRepository = $contactFormServiceRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $contactForms = $this->contactFormServiceRepository->index($request->all());

        return Responser::collection(new ContactFormCollection($contactForms));
    }

    public function show(ContactForm $contactForm): JsonResponse
    {
        $contactForm = $this->contactFormServiceRepository->show($contactForm);

        return Responser::info(new ContactFormResource($contactForm));
    }

    public function destroy(ContactForm $contactForm): JsonResponse
    {
        $this->contactFormServiceRepository->destroy($contactForm);

        return Responser::deleted();
    }
}
