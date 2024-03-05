<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Repository\Admin\Category\CategoryServiceInterface as CategoryServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface;
use App\Services\ProductService\V1\Requests\Admin\Category\CreateRequest;
use App\Services\ProductService\V1\Requests\Admin\Category\SearchRequest;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryBreadcrumbResource;
use App\Services\ProductService\V1\Resources\Admin\Category\CategoryResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Celysium\Media\Facades\Media;

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

    public function search(SearchRequest $request): JsonResponse
    {
        $categories = Category::search($request->get('query'))->paginate($request->get('perPage'));

        return Responser::collection(CategoryResource::collection($categories));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image' => $media]);
        }

        if ($request->file('icon')) {
            $media = Media::upload($request->file('icon'));
            $data = array_merge($data, ['icon' => $media]);
        }

        $category = $this->categoryServiceRepository->store($data);

        return Responser::created(new CategoryResource($category));
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $data = $request->all();
        if ($request->file('image')) {
            $media = Media::upload($request->file('image'));
            $data = array_merge($data, ['image' => $media]);
        }

        if ($request->file('icon')) {
            $media = Media::upload($request->file('icon'));
            $data = array_merge($data, ['icon' => $media]);
        }

        $category = $this->categoryServiceRepository->update($category, $data);

        return Responser::success(new CategoryResource($category));
    }

    public function show(Category $category): JsonResponse
    {
        $category = $this->categoryServiceRepository->show($category);

        return Responser::info(new CategoryResource($category));
    }

    public function showChildren(Request $request, Category $category): JsonResponse
    {
        /** @var Category $category */
        $category = $this->categoryServiceRepository->show($category);

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
            'products_count' => $category->products->count(),
            'children'       => CategoryResource::collection($children),
        ]);
    }

    public function showNested(FlatProductServiceInterface $flatProductService, Request $request, Category $category): JsonResponse
    {
        $queries = $request->all();
        $categories = $this->categoryServiceRepository->index(['export_type' => 'collection', 'sort_by' => 'position', 'sort_direction' => 'asc']);
        $nestedCategories = $flatProductService->nestedCategories($categories, $category->id, [], isset($queries['in_menu']) && $queries['in_menu'] == 1);

        return Responser::info(['categories' => $nestedCategories]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryServiceRepository->destroy($category);

        return Responser::deleted();
    }

    public function sitemap(): array
    {
        return Category::all(['id', 'title', 'slug'])->toArray();
    }

    public function getProducts(Category $category): JsonResponse
    {
        $products = $this->categoryServiceRepository->getProducts($category);

        return Responser::info(ProductResource::collection($products));
    }
}
