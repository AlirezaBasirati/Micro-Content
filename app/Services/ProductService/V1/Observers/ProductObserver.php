<?php

namespace App\Services\ProductService\V1\Observers;

use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceInterface;

class ProductObserver
{
    public function __construct(private readonly FlatProductServiceInterface $flatProductService)
    {
    }

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Order "created" event.
     */
    public function created(Product $product): void
    {
        $this->flatProductService->make([
            'sku' => $product->sku,
            'store_id' => 1,
            'batch_id' => null,
            'merchant_id' => 1,
            'price_original' => 0,
            'price_promoted' => null,
            'status' => 0,
            'quantity' => 0,
        ]);
    }
}
