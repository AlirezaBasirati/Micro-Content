<?php

namespace App\Services\ProductService\V1\Controllers\External\Product;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Repository\External\Product\ProductServiceInterface as ExternalProductServiceInterface;
use App\Services\ProductService\V1\Requests\External\Product\ProductsRequest;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class IntegrateController extends Controller
{
    public function __construct(private readonly ExternalProductServiceInterface $productService)
    {
    }

    public function products(ProductsRequest $request): JsonResponse
    {
        $this->productService->storeProductBySAP($request->validated());
        return Responser::success();
    }
}
