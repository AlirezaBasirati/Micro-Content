<?php

namespace App\Services\ProductService\V1\Controllers\Client;

use App\Exports\FlatProductExport;
use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Client\Category\CategoryServiceInterface;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\Product\FetchRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\ListRequest;
use App\Services\ProductService\V1\Resources\Admin\Brand\BrandSidebarResource;
use App\Services\ProductService\V1\Resources\Admin\FlatProduct\DeepFlatProductResource;
use App\Services\ProductService\V1\Resources\Admin\FlatProduct\FlatProductBasicResource;
use App\Services\ProductService\V1\Resources\Admin\FlatProduct\FlatProductResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FlatProductController extends Controller
{
    public function __construct(private readonly FlatProductServiceRepository $flatProductServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->index($request->all());

        if (isset($request['group_by'])) {
            $grouped = [];
            foreach ($flatProducts as $key => $flatProduct) {
                $grouped[$key] = FlatProductResource::collection($flatProduct);
            }
            return Responser::collection($grouped);


        }
        return Responser::collection(FlatProductResource::collection($flatProducts));
    }

    public function filters(Request $request): JsonResponse
    {
        $filters = $this->flatProductServiceRepository->filter($request->all());

        return Responser::info([
            'brands'     => BrandSidebarResource::collection($filters['brands']),
            'categories' => $filters['categories'],
            'attributes' => $filters['attributes'],
            'price'      => $filters['price']
        ]);
    }

    public function leach(Request $request): JsonResponse
    {
        $filters = $this->flatProductServiceRepository->leach($request->all());

        return Responser::info([
            'brands'     => BrandSidebarResource::collection($filters['brands']),
            'categories' => $filters['categories'],
            'parents' => $filters['parents'],
            'attributes' => $filters['attributes'],
            'price'      => $filters['price']
        ]);
    }

    public function showBySku($sku): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->showBySku($sku);

        return Responser::info(DeepFlatProductResource::collection($flatProducts));
    }

    public function fetch(FetchRequest $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->fetch($request->validated());

        return Responser::info(new DeepFlatProductResource($flatProducts));
    }

    public function listBySku(ListRequest $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->listBySkuAndStore($request->get('products'));

        return Responser::collection(FlatProductResource::collection($flatProducts));
    }

    public function syncInventory(Request $request): JsonResponse
    {
        $this->flatProductServiceRepository->syncInventory($request->get('inventories'));

        return Responser::success();
    }

    public function listById(Request $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->listByIdAndStore($request->get('product_ids'));

        return Responser::collection(FlatProductBasicResource::collection($flatProducts));
    }

    public function checkMarketingCategories(CategoryServiceInterface $categoryService, Request $request): JsonResponse
    {
        $parameters = $request->all();


        $skus = $parameters['skus'];
        $categoryIds = $parameters['values'];

        $categories = collect();

        foreach ($categoryIds as $categoryId) {
            $categories = $categories->merge($categoryService->getChildren($categoryId)->pluck('id'));
        }

        $flatProducts = FlatProduct::query()
            ->whereIn('sku', $skus)
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE);

        switch ($parameters['condition']) {
            case 'isOneOf':
            case 'is':
                $flatProducts = $flatProducts->whereIn('categories.id', $categories->toArray())->get('sku');
                break;
            case 'isNotOneOf':
            case 'isNot':
                $flatProducts = $flatProducts->whereNotIn('categories.id', $categories->toArray())->get('sku');
                break;
            default:
                return Responser::notFound();
        }

        return Responser::info([
            $flatProducts
        ]);
    }

    public function checkMarketingBrandRules(Request $request): JsonResponse
    {
        $parameters = $request->all();

        $skus = $parameters['skus'];
        $brandIds = $parameters['values'];

        $flatProducts = FlatProduct::query()
            ->whereIn('sku', $skus)
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE);

        switch ($parameters['condition']) {
            case 'isOneOf':
            case 'is':
                $flatProducts = $flatProducts->whereIn('brand_id', $brandIds)->get('sku');
                break;
            case 'isNotOneOf':
            case 'isNot':
                $flatProducts = $flatProducts->whereNotIn('brand_id', $brandIds)->get('sku');
                break;
            default:
                return Responser::notFound();
        }

        return Responser::info([
            $flatProducts
        ]);
    }

    public function checkMarketingCampaignRules(Request $request): JsonResponse
    {
        $parameters = $request->all();

        $skus = $parameters['skus'];
        $campaignIds = $parameters['values'];

        $productSkus = Product::query()
            ->whereIn('sku', $skus)
            ->where('status', FlatProduct::STATUS_ACTIVE)
            ->where('visibility', FlatProduct::VISIBILITY_VISIBLE);


        switch ($parameters['condition']) {
            case 'isOneOf':
            case 'is':
                $productSkus = $productSkus->whereHas('campaigns', function ($query) use ($campaignIds) {
                    $query->whereIn('campaigns.id', $campaignIds);
                })
                    ->get(['sku']);
                break;
            case 'isNotOneOf':
            case 'isNot':
                $productSkus = $productSkus->whereHas('campaigns', function ($query) use ($campaignIds) {
                    $query->whereNotIn('campaigns.id', $campaignIds);
                })
                    ->get(['sku']);
                break;
            default:
                return Responser::notFound();
        }

        return Responser::info([
            $productSkus
        ]);
    }

    public function exportCsv(Request $request): BinaryFileResponse
    {
        $flatProducts = $this->flatProductServiceRepository->index(array_merge($request->all(), ['export_type' => 'collection']));

        return Excel::download(new FlatProductExport($flatProducts), 'flat_product_export', \Maatwebsite\Excel\Excel::CSV);
    }

    public function search(Request $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->search($request);

        return Responser::collection(FlatProductResource::collection($flatProducts));
    }

    public function recentSearch(Request $request): JsonResponse
    {
        $searches = $this->flatProductServiceRepository->recentSearches($request);

        return Responser::collection($searches);
    }

    public function popularSearch(): JsonResponse
    {
        $searches = $this->flatProductServiceRepository->popularSearches();

        return Responser::collection($searches);
    }

    public function menuByAttribute(): JsonResponse
    {
        $items = $this->flatProductServiceRepository->menuByAttribute();

        return Responser::info($items);
    }

    public function createMenuByAttribute(): JsonResponse
    {
        $items = $this->flatProductServiceRepository->createMenuByAttribute();

        return Responser::info($items);
    }
}
