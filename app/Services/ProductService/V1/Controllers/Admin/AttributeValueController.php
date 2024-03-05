<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Repository\Admin\AttributeValue\AttributeValueServiceInterface as AttributeValueServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\AttributeValue\CreateRequest;
use App\Services\ProductService\V1\Requests\Admin\AttributeValue\DetailRequest;
use App\Services\ProductService\V1\Resources\Admin\AttributeValue\AttributeValueDetailedResource;
use App\Services\ProductService\V1\Resources\Admin\AttributeValue\AttributeValueResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function __construct(private readonly AttributeValueServiceRepository $attributeValueServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $attributeValues = $this->attributeValueServiceRepository->index($request->all());

        return Responser::collection(AttributeValueResource::collection($attributeValues));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $attributeValue = $this->attributeValueServiceRepository->store($request->validated());

        return Responser::created(new AttributeValueResource($attributeValue));
    }

    public function update(Request $request, AttributeValue $attributeValue): JsonResponse
    {
        $attributeValue = $this->attributeValueServiceRepository->update($attributeValue, $request->all());

        return Responser::success(new AttributeValueResource($attributeValue));
    }

    public function show(AttributeValue $attributeValue): JsonResponse
    {
        $attributeValue = $this->attributeValueServiceRepository->show($attributeValue);

        return Responser::info(new AttributeValueResource($attributeValue));
    }

    public function destroy(AttributeValue $attributeValue): JsonResponse
    {
        $this->attributeValueServiceRepository->destroy($attributeValue);

        return Responser::deleted();
    }

    public function detail(DetailRequest $request): JsonResponse
    {
        $attributeValues = $this->attributeValueServiceRepository->detail($request->all());

        return Responser::info(AttributeValueDetailedResource::collection($attributeValues));
    }
}
