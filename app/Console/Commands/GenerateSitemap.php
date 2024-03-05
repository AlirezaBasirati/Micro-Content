<?php

namespace App\Console\Commands;

use App\Services\ProductService\Models\Brand;
use App\Services\ProductService\Models\Category;
use App\Services\ProductService\Models\Product;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.';

    public function handle(): string
    {
        $sitemap = SitemapGenerator::create(env('SITEMAP_URL'))
            ->getSitemap();

        $sitemap->add(Url::create(env('SITEMAP_URL') . '/aboutUs'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/allCategories'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/contactUs'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/faq'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/login'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/rules'));
        $sitemap->add(Url::create(env('SITEMAP_URL') . '/search'));

        $brandIds = Brand::all()->pluck('id');
        foreach ($brandIds as $brandId) {
            $sitemap->add(Url::create(env('SITEMAP_URL') . '/brand/' . $brandId));
        }

        $productSkus = Product::all()->pluck('sku');
        foreach ($productSkus as $productSku) {
            $sitemap->add(Url::create(env('SITEMAP_URL') . '/productDetail/' . $productSku));
        }

        $mainCategories = Category::query()
            ->where('status', 1)
            ->where('parent_id', 2)
            ->pluck('id');

        foreach ($mainCategories as $mainCategory) {
            $sitemap->add(Url::create(env('SITEMAP_URL') . '/main/' . $mainCategory));
        }

        $subCategories = Category::query()
            ->whereIn('parent_id', $mainCategories)
            ->where('status', 1)
            ->pluck('id');

        foreach ($subCategories as $subCategory) {
            $sitemap->add(Url::create(env('SITEMAP_URL') . '/subCategory/' . $subCategory));
        }

        $productSkus = Product::query()
            ->where('status', 1)
            ->where('visibility', 1)
            ->pluck('sku');

        foreach ($productSkus as $productSku) {
            $sitemap->add(Url::create(env('SITEMAP_URL') . '/productDetail/' . $productSku));
        }

        $sitemap->writeToFile(storage_path('app/public/sitemap.xml'));
        return 'Sitemap Generated';
    }
}
