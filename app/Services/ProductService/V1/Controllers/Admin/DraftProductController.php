<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\DraftProduct;
use App\Services\ProductService\V1\Repository\Admin\DraftProduct\DraftProductServiceInterface as DraftProductRepository;
use App\Services\ProductService\V1\Requests\Admin\DraftProduct\CreateRequest;
use App\Services\ProductService\V1\Resources\Admin\DraftProduct\DraftProductResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DraftProductController extends Controller
{
    public function __construct(private DraftProductRepository $draftProductRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $products = $this->draftProductRepository->index($request->all());

        return Responser::collection(DraftProductResource::collection($products));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $product = $this->draftProductRepository->store($request->validated());

        return Responser::created(new DraftProductResource($product));
    }

    public function show(DraftProduct $draftProduct): JsonResponse
    {
        $draftProduct = $this->draftProductRepository->show($draftProduct);

        return Responser::info(new DraftProductResource($draftProduct));
    }

    public function destroy(DraftProduct $draftProduct): JsonResponse
    {
        $this->draftProductRepository->destroy($draftProduct);

        return Responser::deleted();
    }
}
