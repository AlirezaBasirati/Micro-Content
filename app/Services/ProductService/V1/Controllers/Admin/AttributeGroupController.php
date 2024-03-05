<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\AttributeGroup;
use App\Services\ProductService\V1\Repository\Admin\AttributeGroup\AttributeGroupServiceInterface as AttributeGroupServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\AttributeGroup\AttributeGroupResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    public function __construct(private readonly AttributeGroupServiceRepository $attributeGroupServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $attributeGroups = $this->attributeGroupServiceRepository->index($request->all());

        return Responser::collection(AttributeGroupResource::collection($attributeGroups));
    }

    public function store(Request $request): JsonResponse
    {
        $attributeGroup = $this->attributeGroupServiceRepository->store($request->all());

        return Responser::created(new AttributeGroupResource($attributeGroup));
    }

    public function update(Request $request, AttributeGroup $attributeGroup): JsonResponse
    {
        $attributeGroup = $this->attributeGroupServiceRepository->update($attributeGroup, $request->all());

        return Responser::success(new AttributeGroupResource($attributeGroup));
    }

    public function show(AttributeGroup $attributeGroup): JsonResponse
    {
        $attributeGroup = $this->attributeGroupServiceRepository->show($attributeGroup);

        return Responser::info(new AttributeGroupResource($attributeGroup));
    }

    public function destroy(AttributeGroup $attributeGroup): JsonResponse
    {
        $this->attributeGroupServiceRepository->destroy($attributeGroup);

        return Responser::deleted();
    }
}
