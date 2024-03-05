<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\Newsletter;
use App\Services\ContentManagerService\V1\Resources\Admin\Newsletter\NewsletterCollection;
use App\Services\ContentManagerService\V1\Resources\Admin\Newsletter\NewsletterResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ContentManagerService\V1\Repository\Admin\Newsletter\NewsletterServiceInterface as NewsletterServiceRepository;
use Celysium\Responser\Responser;

class NewsletterController extends Controller
{
    public function __construct(private readonly NewsletterServiceRepository $newsletterServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $newsletters = $this->newsletterServiceRepository->index($request->all());

        return Responser::collection(new NewsletterCollection($newsletters));
    }

    public function store(Request $request): JsonResponse
    {
        $newsletter = $this->newsletterServiceRepository->store($request->all());

        return Responser::created(new NewsletterResource($newsletter));
    }

    public function show(Newsletter $newsletter): JsonResponse
    {
        $newsletter = $this->newsletterServiceRepository->show($newsletter);

        return Responser::info(new NewsletterResource($newsletter));
    }

    public function destroy(Newsletter $newsletter): JsonResponse
    {
        $this->newsletterServiceRepository->destroy($newsletter);

        return Responser::deleted();
    }
}
