<?php

namespace App\Services\ContentManagerService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\Slider;
use App\Services\ContentManagerService\V1\Repository\Admin\Slider\SliderServiceInterface as SliderServiceRepository;
use App\Services\ContentManagerService\V1\Requests\Admin\Slider\CreateRequest;
use App\Services\ContentManagerService\V1\Requests\Admin\Slider\UpdateRequest;
use App\Services\ContentManagerService\V1\Resources\Admin\Slider\SliderCollection;
use App\Services\ContentManagerService\V1\Resources\Admin\Slider\SliderResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(private readonly SliderServiceRepository $sliderServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $sliders = $this->sliderServiceRepository->index($request->all());

        return Responser::collection(new SliderCollection($sliders));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $slider = $this->sliderServiceRepository->store($request->all());

        return Responser::created(new SliderResource($slider));
    }

    public function update(UpdateRequest $request, Slider $slider): JsonResponse
    {
        $slider = $this->sliderServiceRepository->update($slider, $request->all());

        return Responser::success(new SliderResource($slider));
    }

    public function show(Slider $slider): JsonResponse
    {
        $slider = $this->sliderServiceRepository->show($slider);

        return Responser::info(new SliderResource($slider));
    }

    public function destroy(Slider $slider): JsonResponse
    {
        $this->sliderServiceRepository->destroy($slider);

        return Responser::deleted();
    }
}
