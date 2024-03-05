<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\SliderPosition;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderPosition\SliderPositionServiceInterface as SliderPositionServiceRepository;
use App\Services\ContentManagerService\V1\Requests\Admin\SliderPosition\CreateRequest;
use App\Services\ContentManagerService\V1\Requests\Admin\SliderPosition\UpdateRequest;
use App\Services\ContentManagerService\V1\Resources\Admin\SliderPosition\SliderPositionCollection;
use App\Services\ContentManagerService\V1\Resources\Admin\SliderPosition\SliderPositionResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderPositionController extends Controller
{
    private SliderPositionServiceRepository $sliderPositionRepository;

    public function __construct(SliderPositionServiceRepository $sliderPositionRepository)
    {
        $this->sliderPositionRepository = $sliderPositionRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $sliderPositions = $this->sliderPositionRepository->index($request->all());

        return Responser::collection(new SliderPositionCollection($sliderPositions));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $sliderPosition = $this->sliderPositionRepository->store($request->all());

        return Responser::created(new SliderPositionResource($sliderPosition));
    }

    public function update(UpdateRequest $request, SliderPosition $sliderPosition): JsonResponse
    {
        $sliderPosition = $this->sliderPositionRepository->update($sliderPosition, $request->all());

        return Responser::success(new SliderPositionResource($sliderPosition));
    }

    public function show(SliderPosition $sliderPosition): JsonResponse
    {
        $sliderPosition = $this->sliderPositionRepository->show($sliderPosition);

        return Responser::info(new SliderPositionResource($sliderPosition));
    }

    public function destroy(SliderPosition $sliderPosition): JsonResponse
    {
        $this->sliderPositionRepository->destroy($sliderPosition);

        return Responser::deleted();
    }
}
