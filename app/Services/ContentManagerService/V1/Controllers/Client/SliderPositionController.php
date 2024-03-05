<?php

namespace App\Services\ContentManagerService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ContentManagerService\V1\Models\SliderPosition;
use App\Services\ContentManagerService\V1\Repository\Client\SliderPosition\SliderPositionServiceInterface as SliderPositionServiceRepository;
use App\Services\ContentManagerService\V1\Resources\Client\SliderPosition\SliderPositionResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class SliderPositionController extends Controller
{
    public function __construct(private readonly SliderPositionServiceRepository $sliderPositionRepository)
    {
        //
    }

    public function show(SliderPosition $sliderPosition): JsonResponse
    {
        $sliderPosition = $this->sliderPositionRepository->show($sliderPosition);

        return Responser::info(new SliderPositionResource($sliderPosition));
    }
}
