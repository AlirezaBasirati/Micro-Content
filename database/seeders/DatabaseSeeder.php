<?php

namespace Database\Seeders;

use App\Services\ContentManagerService\V1\Database\Seeder\SliderSeeder;
use App\Services\ProductService\V1\Database\Seeder\AttributeSeeder;
use App\Services\ProductService\V1\Database\Seeder\AttributeValueSeeder;
use App\Services\ProductService\V1\Database\Seeder\CategorySeeder;
use App\Services\ProductService\V1\Database\Seeder\BrandSeeder;
use App\Services\ProductService\V1\Database\Seeder\ProductSeeder;
use App\Services\ProductService\V1\Database\Seeder\WidgetSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            SliderSeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            ProductSeeder::class,
            WidgetSeeder::class,
        ]);
    }
}
