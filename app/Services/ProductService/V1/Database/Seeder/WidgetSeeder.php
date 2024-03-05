<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\Widget;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    public function run(): void
    {
        /** @var Widget $widget */
        $widget = Widget::query()->updateOrCreate([
            'name' => 'recommendation',
            'slug' => 'recommendation',
        ]);

        $productIds = Product::query()->inRandomOrder()->limit(20)->pluck('id');
        $widget->products()->sync($productIds);
    }
}
