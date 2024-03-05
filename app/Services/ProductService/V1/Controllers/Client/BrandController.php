<?php

namespace App\Services\ProductService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Repository\Client\Brand\BrandServiceInterface as BrandServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\Brand\SearchRequest;
use App\Services\ProductService\V1\Resources\Client\Brand\BrandResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(private readonly BrandServiceRepository $brandServiceRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $brands = $this->brandServiceRepository->index($request->all());

        return Responser::info(BrandResource::collection($brands));
    }

    public function search(SearchRequest $request): JsonResponse
    {
        $brands = Brand::search($request->get('query'))->paginate($request->get('perPage'));

        return Responser::info(BrandResource::collection($brands));
    }

    public function show(Brand $brand): JsonResponse
    {
        $brand = $this->brandServiceRepository->show($brand);

        return Responser::info(new BrandResource($brand));
    }

    public function getProducts(Brand $brand): JsonResponse
    {
        $products = $this->brandServiceRepository->getProducts($brand);

        return Responser::collection(ProductResource::collection($products));
    }
}
