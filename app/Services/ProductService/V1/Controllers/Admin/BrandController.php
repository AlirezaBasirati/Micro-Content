<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Repository\Admin\Brand\BrandServiceInterface as BrandServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\Brand\CreateRequest;
use App\Services\ProductService\V1\Requests\Admin\Brand\SearchRequest;
use App\Services\ProductService\V1\Resources\Admin\Brand\BrandResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Celysium\Media\Facades\Media;
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

        return Responser::collection(BrandResource::collection($brands));
    }

    public function search(SearchRequest $request): JsonResponse
    {
        $brands = Brand::search($request->get('query'))->paginate($request->get('perPage'));

        return Responser::info(BrandResource::collection($brands));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image' => $media]);
        }

        if ($request->file('thumbnail')) {
            $media = Media::upload($request->file('thumbnail'));
            $data = array_merge($data, ['thumbnail' => $media]);
        }

        $brand = $this->brandServiceRepository->store($data);

        return Responser::created(new BrandResource($brand));
    }

    public function update(Request $request, Brand $brand): JsonResponse
    {
        $data = $request->all();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image' => $media]);
        }

        if ($request->file('thumbnail')) {
            $media = Media::upload($request->file('thumbnail'));
            $data = array_merge($data, ['thumbnail' => $media]);
        }

        $brand = $this->brandServiceRepository->update($brand, $data);

        return Responser::success(new BrandResource($brand));
    }

    public function show(Brand $brand): JsonResponse
    {
        $brand = $this->brandServiceRepository->show($brand);

        return Responser::info(new BrandResource($brand));
    }

    public function destroy(Brand $brand): JsonResponse
    {
        $this->brandServiceRepository->destroy($brand);

        return Responser::deleted();
    }

    public function getProducts(Brand $brand): JsonResponse
    {
        $products = $this->brandServiceRepository->getProducts($brand);

        return Responser::collection(ProductResource::collection($products));
    }
}
