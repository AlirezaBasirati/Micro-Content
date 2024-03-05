<?php

namespace App\Listeners;

use App\Events\ProductUpdate;
use App\Services\ProductService\V1\Commands\SyncFlatProduct;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceInterface;
use Illuminate\Support\Facades\Artisan;

class UpdateFlatProduct
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private readonly FlatProductServiceInterface $flatProductServiceRepository)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\ProductUpdate $event
     * @return void
     */
    public function handle(ProductUpdate $event)
    {
        $product = $event->product;

        $flatProducts = FlatProduct::query()
            ->where('sku', $product->sku)->get();

        /** @var FlatProduct $flatProduct */
        foreach ($flatProducts as $flatProduct) {
            $data = $this->flatProductServiceRepository->mapper($product);
            $flatProduct->fill($data);
            $flatProduct->save();
        }
    }
}
