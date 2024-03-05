<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Attribute;
use App\Services\ProductService\V1\Repository\Admin\Attribute\AttributeServiceInterface as AttributeServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\Attribute\CreateRequest;
use App\Services\ProductService\V1\Requests\Admin\Attribute\UpdateRequest;
use App\Services\ProductService\V1\Resources\Admin\Attribute\AttributeResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct(private readonly AttributeServiceRepository $attributeServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $attributes = $this->attributeServiceRepository->index($request->all());

        return Responser::collection(AttributeResource::collection($attributes));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $attribute = $this->attributeServiceRepository->store($request->validated());

        return Responser::created(new AttributeResource($attribute));
    }

    public function update(UpdateRequest $request, Attribute $attribute): JsonResponse
    {
        $attribute = $this->attributeServiceRepository->update($attribute, $request->validated());

        return Responser::success(new AttributeResource($attribute));
    }

    public function show(Attribute $attribute): JsonResponse
    {
        $attribute = $this->attributeServiceRepository->show($attribute);

        return Responser::info(new AttributeResource($attribute));
    }

    public function destroy(Attribute $attribute): JsonResponse
    {
        $this->attributeServiceRepository->destroy($attribute);

        return Responser::deleted();
    }
}
