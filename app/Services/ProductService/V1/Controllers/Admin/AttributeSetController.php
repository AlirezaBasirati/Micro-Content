<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\AttributeSet;
use App\Services\ProductService\V1\Repository\Admin\AttributeSet\AttributeSetServiceInterface as AttributeSetServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\AttributeSet\AttributeSetResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeSetController extends Controller
{
    public function __construct(private readonly AttributeSetServiceRepository $attributeSetServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $attributeSets = $this->attributeSetServiceRepository->index($request->all());

        return Responser::collection(AttributeSetResource::collection($attributeSets));
    }

    public function store(Request $request): JsonResponse
    {
        /** @var AttributeSet $attributeSet */
        $attributeSet = $this->attributeSetServiceRepository->store($request->all());
        if ($request->has('attribute_ids')) {
            $attributeSet = $this->attributeSetServiceRepository->assignAttributes($attributeSet, $request->get('attribute_ids'));
        }

        return Responser::created(new AttributeSetResource($attributeSet));
    }

    public function update(Request $request, AttributeSet $attributeSet): JsonResponse
    {
        /** @var AttributeSet $attributeSet */
        $attributeSet = $this->attributeSetServiceRepository->update($attributeSet, $request->all());
        if ($request->has('attribute_ids')) {
            $attributeSet = $this->attributeSetServiceRepository->assignAttributes($attributeSet, $request->get('attribute_ids'));
        }

        return Responser::success(new AttributeSetResource($attributeSet));
    }

    public function show(AttributeSet $attributeSet): JsonResponse
    {
        $attributeSet = $this->attributeSetServiceRepository->show($attributeSet);

        return Responser::info(new AttributeSetResource($attributeSet));
    }

    public function destroy(AttributeSet $attributeSet): JsonResponse
    {
        $this->attributeSetServiceRepository->destroy($attributeSet);

        return Responser::deleted();
    }

    public function assignAttributes(AttributeSet $attributeSet, Request $request): JsonResponse
    {
        $attributeSet = $this->attributeSetServiceRepository->assignAttributes($attributeSet, $request->get('attribute_ids'));

        return Responser::success($attributeSet);
    }
}
