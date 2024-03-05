<?php

namespace App\Services\ProductService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Repository\Client\Category\CategoryServiceInterface as CategoryServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryBreadcrumbResource;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryServiceRepository $categoryServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryServiceRepository->index($request->all());

        return Responser::collection(CategoryResource::collection($categories));
    }

    public function show(Category $category): JsonResponse
    {
        $category = $this->categoryServiceRepository->show($category);

        return Responser::info(new CategoryResource($category));
    }

    public function showChildren(Request $request, Category $category): JsonResponse
    {
        $children = $category->children();

        if ($request->has('in_menu')) {
            $children = $children->where('visible_in_menu', '1');
        }
        $children = $children->get();

        return Responser::info([
            'id'             => $category->id,
            'title'          => $category->title,
            'icon'           => $category->icon ?? null,
            'image'          => $category->image ?? null,
            'color'          => $category->color ?? null,
            'description'    => $category->description ?? null,
            'level'          => $category->level,
            'position'       => $category->position,
            'products_count' => count($category->products),
            'children'       => CategoryResource::collection($children),
        ]);
    }

    public function showNested(FlatProductServiceInterface $flatProductService, Request $request, Category $category): JsonResponse
    {
        $categories = $this->categoryServiceRepository->index(['export_type' => 'collection', 'sort_by' => 'position', 'sort_direction' => 'asc']);
        $nestedCategories = $flatProductService->nestedCategories($categories, $category->id, [], isset($queries['in_menu']) && $queries['in_menu'] == 1);

        return Responser::info(['categories' => $nestedCategories]);
    }

    public function breadcrumb(Category $category): JsonResponse
    {
        $breadcrumb = $this->categoryServiceRepository->breadcrumb($category);

        return Responser::info(CategoryBreadcrumbResource::collection($breadcrumb));
    }
}
