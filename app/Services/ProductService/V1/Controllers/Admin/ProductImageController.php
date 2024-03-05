<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Events\ProductUpdate;
use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductImage;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductImageServiceInterface as ProductImageServiceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Celysium\Media\Facades\Media;
use Celysium\Responser\Responser;

class ProductImageController extends Controller
{
    public function __construct(private readonly ProductImageServiceRepository $productImageServiceRepository)
    {
        //
    }

    public function add(Request $request, Product $product): JsonResponse
    {
        $media = Media::upload($request->file('image'));

        $position = $product->categories()->max('position') ?? 1;
        $position++;

        $this->productImageServiceRepository->addFile($product, $media, $position);
        event(new ProductUpdate($product));

        return Responser::created($product);
    }

    public function update(Product $product, ProductImage $productImage, Request $request): JsonResponse
    {
        $productImage = $this->productImageServiceRepository->update($productImage, $request->all());
        event(new ProductUpdate($product));

        return Responser::info($productImage);
    }

    public function remove(Product $product, ProductImage $productImage): JsonResponse
    {
        $productImage = $this->productImageServiceRepository->removeFile($product, $productImage);
        event(new ProductUpdate($product));

        return Responser::deleted($productImage);
    }
}
