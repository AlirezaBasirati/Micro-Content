<?php

namespace App\Services\ProductService\V1\Repository\External\Product;

use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductServiceRepository implements ProductServiceInterface
{
    public function __construct(private readonly Product $product)
    {
    }

    public function storeProductBySAP(array $parameters): void
    {
        DB::beginTransaction();
        /** @var Category $category */
        $category = Category::query()->updateOrCreate(
            ['slug' => 'sap'],
            [
                'parent_id'       => Category::ROOT,
                'title'           => 'sap',
                'status'          => Category::ACTIVE,
                'level'           => 1,
                'position'        => 1,
                'visible_in_menu' => 0,
            ]);

        /** @var Brand $brand */
        $brand = Brand::query()->updateOrCreate(['slug' => 'etc', 'name' => 'etc']);

        foreach ($parameters['data'] as $item) {
            /** @var Product $product */
            $product = $this->product->query()->updateOrCreate(
                [
                    'sku'       => strval(intval($item['SKU'])),
                ],
                [
                    'public_id' => $item['PUBLIC_ID'] . rand(11111, 9999999),
                    'name'        => $item['DESCRIPTION'],
                    'url_key'     => '',
                    'visibility'  => Product::VISIBILITY_INVISIBLE,
                    'description' => $item['DESCRIPTION'],
                    'barcode'     => $item['BARCODE'],
                    'weight'      => $item['WEIGHT'],
                    'dimensions'  => sprintf('%s,%s,%s', $item['LENGTH'], $item['WIDTH'], $item['HEIGHT']),
                    'tax_class'   => $item['TAX'],
                    'brand_id'    => $brand->id,
                ]);
            ProductCategory::query()->updateOrCreate(['product_id' => $product->id, 'category_id' => $category->id]);
        }
        DB::commit();
    }
}
