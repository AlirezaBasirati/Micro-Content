<?php

namespace App\Services\CampaignService\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\CampaignImport;
use App\Services\CampaignService\V1\Models\Campaign;
use App\Services\CampaignService\V1\Resources\CampaignResource;
use App\Services\ContentManagerService\V1\Models\Slider;
use App\Services\ContentManagerService\V1\Models\SliderPosition;
use App\Services\ContentManagerService\V1\Repository\Admin\SliderPosition\SliderPositionServiceInterface;
use App\Services\ContentManagerService\V1\Resources\Admin\Slider\SliderResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CampaignService\V1\Repository\CampaignServiceInterface;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Celysium\Responser\Responser;

class CampaignController extends Controller
{
    public function __construct(private readonly CampaignServiceInterface $campaignService)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $campaigns = $this->campaignService->index($request->all());

        return Responser::collection(CampaignResource::collection($campaigns));
    }

    public function store(Request $request): JsonResponse
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignService->store($request->all());

        if ($request->has('product_ids')) {
            $productIds = $request->get('product_ids');
            $campaign = $this->campaignService->assignProducts($campaign, $productIds);
        }

        return Responser::created(new CampaignResource($campaign));
    }

    public function update(Request $request, Campaign $campaign): JsonResponse
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignService->update($campaign, $request->all());

        if ($request->has('product_ids')) {
            $productIds = $request->get('product_ids');
            $campaign = $this->campaignService->assignProducts($campaign, $productIds);
        }

        return Responser::info(new CampaignResource($campaign));
    }

    public function show(Campaign $campaign): JsonResponse
    {
        $campaign = $this->campaignService->show($campaign);

        return Responser::info(new CampaignResource($campaign));
    }

    public function products(Campaign $campaign): JsonResponse
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignService->show($campaign);

        return Responser::collection(ProductResource::collection($campaign->products));
    }

    public function sliders(SliderPositionServiceInterface $sliderPositionService, Campaign $campaign): JsonResponse
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignService->show($campaign);

        $sliderPositions = $sliderPositionService->index([
            'prefix'   => 'campaign-' . $campaign->slug . '-',
            'export_type' => 'collection'
        ]);

        /** @var SliderPosition $mobileSliderPosition */
        $mobileSliderPosition = $sliderPositions->where('max_width', 640)->first();

        /** @var SliderPosition $desktopSliderPosition */
        $desktopSliderPosition = $sliderPositions->where('max_width', 1920)->first();

        /** @var Slider $mobileSlider */
        $mobileSlider = $mobileSliderPosition->sliders()->first();

        /** @var Slider $desktopSlider */
        $desktopSlider = $desktopSliderPosition->sliders()->first();

        return Responser::info([
            'mobile'  => new SliderResource($mobileSlider),
            'desktop' => new SliderResource($desktopSlider),
        ]);
    }

    public function destroy(Campaign $campaign): JsonResponse
    {
        $this->campaignService->destroy($campaign);

        return Responser::deleted();
    }

    public function assignProductsViaFile(Campaign $campaign, Request $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $filePath = 'campaigns/' . $filename;

        Storage::disk('local')->putFileAs(
            $filePath,
            $uploadedFile,
            $filename
        );

        Excel::import(new CampaignImport($this->campaignService, $campaign), $request->file('file'), readerType: \Maatwebsite\Excel\Excel::CSV);

        return Responser::success();
    }

    public function assignProducts(Campaign $campaign, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $campaign = $this->campaignService->assignProducts($campaign, $productIds);

        return Responser::info(new CampaignResource($campaign));
    }
}
