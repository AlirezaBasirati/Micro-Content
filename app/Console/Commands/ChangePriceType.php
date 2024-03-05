<?php

namespace App\Console\Commands;

use App\Services\ProductService\Models\FlatProduct;
use App\Services\ProductService\Models\Product;
use Illuminate\Console\Command;

class ChangePriceType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $index = 0;
        $flatProducts = FlatProduct::query()->chunk(100, function ($products) use (&$index) {
            /** @var FlatProduct $product */
            foreach ($products as $key => $product) {
                $product->price_original = (int)$product->price_original;
                $product->price_promoted = (int)$product->price_promoted;
                $product->save();
                $this->info($index . '|' . $key);
            }
            $index++;
        });
    }
}
