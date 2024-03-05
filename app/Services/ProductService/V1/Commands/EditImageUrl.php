<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\ContentManagerService\V1\Models\SliderItem;
use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class EditImageUrl extends Command
{
    protected $signature = 'image:edit {--find=} {--replace=} {--flat}';
    protected $description = 'Edit all images urls';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $find = $this->option('find');
        $replace = $this->option('replace');

        ProductImage::query()->update(['url' => DB::raw("REPLACE(url,  '$find', '$replace')")]);

        SliderItem::query()->update(['image_url' => DB::raw("REPLACE(image_url,  '$find', '$replace')")]);

        Brand::query()->update([
            'image' => DB::raw("REPLACE(image,  '$find', '$replace')"),
            'thumbnail' => DB::raw("REPLACE(thumbnail,  '$find', '$replace')")
        ]);

        Category::query()->update([
            'image' => DB::raw("REPLACE(image,  '$find', '$replace')"),
            'icon' => DB::raw("REPLACE(icon,  '$find', '$replace')")
        ]);

        if ($this->option('flat')) {
            Artisan::call('fill:flat_product', ['only' => ['brand', 'brand_thumbnail', 'gallery', 'categories']]);
        }
    }
}
