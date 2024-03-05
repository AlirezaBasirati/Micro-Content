<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductCategory;
use App\Services\ProductService\V1\Models\ProductImage;
use App\Services\ProductService\V1\Models\ProductValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public string $products;

    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $file = File::get('app/Services/ProductService/V1/Database/Seeder/product.json');
        $products = json_decode($file);
        foreach ($products as $key => $product) {
            $id = Product::query()->create([

                'name'       => $product->title_fa,
                'type'       => 'simple',
                'sku'        => $product->id,
                'url_key'    => $product->id,
                'public_id'  => $product->id,
                'tax_class'  => 9,
                'status'     => 1,
                'brand_id'   => rand(1, 5),
                'visibility' => 1,
            ]);

            ProductCategory::query()->create([
                'product_id'  => $id->id,
                'category_id' => rand(2, 9),
            ]);

            ProductImage::query()->create([
                'product_id'   => $id->id,
                'url'          => head($product->images->main->url),
                'position'     => 1,
                'is_thumbnail' => 1,
            ]);

            ProductValue::query()->create([
                'product_id'         => $id->id,
                'attribute_value_id' => 2,
                'attribute_id'       => 3,
            ]);
        }
    }
}
