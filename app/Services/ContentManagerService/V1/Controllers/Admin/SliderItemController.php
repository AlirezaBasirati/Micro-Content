<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\SliderItem;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderItem\SliderItemServiceInterface as SliderItemServiceRepository;
use App\Services\ContentManagerService\V1\Requests\Admin\SliderItem\CreateRequest;
use App\Services\ContentManagerService\V1\Requests\Admin\SliderItem\UpdateRequest;
use App\Services\ContentManagerService\V1\Resources\Admin\SliderItem\SliderItemCollection;
use App\Services\ContentManagerService\V1\Resources\Admin\SliderItem\SliderItemResource;
use Celysium\Media\Facades\Media;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderItemController extends Controller
{
    private SliderItemServiceRepository $sliderItemRepository;
    public function __construct(SliderItemServiceRepository $sliderItemRepository)
    {
        $this->sliderItemRepository = $sliderItemRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $sliderItems = $this->sliderItemRepository->index($request->all());

        return Responser::collection(new SliderItemCollection($sliderItems));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $data = $request->all();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image_url' => $media]);
        }

        $sliderItem = $this->sliderItemRepository->store($data);

        return Responser::created(new SliderItemResource($sliderItem));
    }

    public function update(UpdateRequest $request, SliderItem $sliderItem): JsonResponse
    {
        $data = $request->all();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image_url' => $media]);
        }

        $sliderItem = $this->sliderItemRepository->update($sliderItem, $data);

        return Responser::success(new SliderItemResource($sliderItem));
    }

    public function show(SliderItem $sliderItem): JsonResponse
    {
        $sliderItem = $this->sliderItemRepository->show($sliderItem);

        return Responser::info(new SliderItemResource($sliderItem));
    }

    public function destroy(SliderItem $sliderItem): JsonResponse
    {
        $this->sliderItemRepository->destroy($sliderItem);

        return Responser::deleted();
    }
}
