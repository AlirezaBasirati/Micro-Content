<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\Faq;
use App\Services\ContentManagerService\V1\Repository\Admin\Faq\FaqServiceInterface as FaqServiceRepository;
use App\Services\ContentManagerService\V1\Requests\Admin\Faq\CreateRequest;
use App\Services\ContentManagerService\V1\Requests\Admin\Faq\UpdateRequest;
use App\Services\ContentManagerService\V1\Resources\Admin\Faq\FaqResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private FaqServiceRepository $faqServiceRepository;

    public function __construct(FaqServiceRepository $faqServiceRepository)
    {
        $this->faqServiceRepository = $faqServiceRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $faqs = $this->faqServiceRepository->index($request->all());

        return Responser::collection(FaqResource::collection($faqs));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $faq = $this->faqServiceRepository->store($request->all());

        return Responser::created(new FaqResource($faq));
    }

    public function update(UpdateRequest $request, Faq $faq): JsonResponse
    {
        $faq = $this->faqServiceRepository->update($faq, $request->all());

        return Responser::success(new FaqResource($faq));
    }

    public function show(Faq $faq): JsonResponse
    {
        $faq = $this->faqServiceRepository->show($faq);

        return Responser::info(new FaqResource($faq));
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $this->faqServiceRepository->destroy($faq);

        return Responser::deleted();
    }
}
