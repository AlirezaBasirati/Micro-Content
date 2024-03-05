<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Repository\Admin\Brand\BrandServiceInterface as BrandServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\FlatBrand\FlatBrandServiceInterface as FlatBrandServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\Brand\BrandResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlatBrandController extends Controller
{
    public function __construct(private readonly FlatBrandServiceRepository $flatBrandServiceRepository, private readonly BrandServiceRepository $brandServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $flatBrands = $this->flatBrandServiceRepository->index($request->all());

        $brands = $this->brandServiceRepository->index([
            'brand_ids' => $flatBrands->first()?->brands,
            'is_featured',
            'is_active'
        ]);

        return Responser::collection(BrandResource::collection($brands));
    }
}
