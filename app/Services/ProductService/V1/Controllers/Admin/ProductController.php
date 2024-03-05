<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Events\ProductUpdate;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Imports\UpdateProductsImport;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductImportLog;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductServiceInterface as ProductServiceRepository;
use App\Services\ProductService\V1\Requests\Admin\Product\AssignCategoryRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\BulkAssignRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\CreateRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\ExtendedCreateRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\ExtendedUpdateRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\ListByIdRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\ProductImportRequest;
use App\Services\ProductService\V1\Requests\Admin\Product\UpdateVisibilityRequest;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductDetailedResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductExcerptResource;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Celysium\Authenticate\Facades\Authenticate;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductServiceRepository $productServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $products = $this->productServiceRepository->index($request->all());
        return Responser::collection(ProductResource::collection($products));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $product = $this->productServiceRepository->store($request->validated());

        return Responser::created(new ProductResource($product));
    }

    public function extendedCreate(ExtendedCreateRequest $request): JsonResponse
    {
        $product = $this->productServiceRepository->extendedCreate($request->validated());

        return Responser::created(new ProductResource($product));
    }

    public function extendedUpdate(Product $product, ExtendedUpdateRequest $request): JsonResponse
    {
        $product = $this->productServiceRepository->extendedUpdate($product, $request->validated());
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        /** @var Product $product */
        $product = $this->productServiceRepository->update($product, $request->all());
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function show(Product $product): JsonResponse
    {
        $product = $this->productServiceRepository->show($product);

        return Responser::info(new ProductDetailedResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productServiceRepository->destroy($product);

        return Responser::deleted();
    }

    public function productCategories(ListByIdRequest $request): JsonResponse
    {
        $products = $this->productServiceRepository->listWithCategories($request->get('product_ids'));

        return Responser::info([
            'products' => ProductExcerptResource::collection($products)
        ]);
    }

    public function attributeValue(Product $product, AttributeValue $attributeValue): JsonResponse
    {
        $product = $this->productServiceRepository->assignAttribute($product, $attributeValue);
        event(new ProductUpdate($product));

        return Responser::created(new ProductResource($product));
    }

    public function removeAttributeValue(Product $product, AttributeValue $attributeValue): JsonResponse
    {
        $product = $this->productServiceRepository->unassignAttribute($product, $attributeValue);
        event(new ProductUpdate($product));

        return Responser::deleted(new ProductResource($product));
    }

    public function addConfigurableProduct(Product $product, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $product = $this->productServiceRepository->addConfigurable($product, $productIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function removeConfigurableProduct(Product $product, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $product = $this->productServiceRepository->removeConfigurable($product, $productIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function addBundleProduct(Product $product, Request $request): JsonResponse
    {
        $products = $request->get('products');
        $product = $this->productServiceRepository->addBundles($product, $products);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function removeBundleProduct(Product $product, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $product = $this->productServiceRepository->removeBundles($product, $productIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function addRelatedProduct(Product $product, Request $request): JsonResponse
    {
        $products = $request->get('product_ids');
        $product = $this->productServiceRepository->addRelated($product, $products);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function removeRelatedProduct(Product $product, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $product = $this->productServiceRepository->removeRelated($product, $productIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function assignCategories(Product $product, AssignCategoryRequest $request): JsonResponse
    {
        $categoryIds = $request->get('category_ids');
        $product = $this->productServiceRepository->assignCategories($product, $categoryIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function unassignCategories(Product $product, AssignCategoryRequest $request): JsonResponse
    {
        $categoryIds = $request->get('category_ids');
        $product = $this->productServiceRepository->unassignCategories($product, $categoryIds);
        event(new ProductUpdate($product));

        return Responser::info(new ProductResource($product));
    }

    public function importByFile(ProductImportRequest $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $filePath = 'imports/' . $filename;

        Storage::disk('local')->putFileAs(
            $filePath,
            $uploadedFile,
            $filename
        );

        /** @var ProductImportLog $log */
        $log = ProductImportLog::query()
            ->create([
                'file_path' => $filePath,
                'actor_id'  => Authenticate::id()
            ]);

        Excel::import(new ProductsImport($this->productServiceRepository), $request->file('file'), readerType: \Maatwebsite\Excel\Excel::CSV);

        $log->status = ProductImportLog::STATUS_SUCCESS;
        $log->save();

        return Responser::success();
    }

    public function bulkUpdate(UpdateVisibilityRequest $request): JsonResponse
    {
        $this->productServiceRepository->bulkUpdate($request->all());

        return Responser::success();
    }

    public function exportCsv(Request $request): BinaryFileResponse
    {
        return Excel::download(new ProductExport($request->all()), 'product_export', \Maatwebsite\Excel\Excel::CSV);
    }

    public function updateViaFile(Request $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $filePath = 'imports/' . $filename;

        Storage::disk('local')->putFileAs(
            $filePath,
            $uploadedFile,
            $filename
        );

        /** @var ProductImportLog $log */
        $log = ProductImportLog::query()
            ->create([
                'file_path' => $filePath,
                'actor_id'  => Authenticate::id()
            ]);

        Excel::import(new UpdateProductsImport(), $request->file('file'), readerType: \Maatwebsite\Excel\Excel::CSV);

        $log->status = ProductImportLog::STATUS_SUCCESS;
        $log->save();

        return Responser::success();
    }

    public function bulkAssignProductCategory(BulkAssignRequest $request): JsonResponse
    {
        $count = $this->productServiceRepository->bulkProductCategoryAssign($request->validated());

        return Responser::success(['count' => $count]);
    }
}
