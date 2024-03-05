<?php

namespace App\Services\ProductService\V1\Repository\Admin\OrderedProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\OrderedProduct;
use Celysium\Base\Repository\BaseRepository;
use JetBrains\PhpStorm\Pure;

class OrderedProductServiceRepository extends BaseRepository implements OrderedProductServiceInterface
{
    #[Pure] public function __construct(OrderedProduct $model)
    {
        parent::__construct($model);
    }

    public function orderedProducts(array $parameters): void
    {
        foreach ($parameters['items'] as $parameter) {
            $orderedProduct = OrderedProduct::query()->where('product_id', $parameter['product']['id'])->first();
            if ($orderedProduct) {
                $orderedQuantity = $orderedProduct->ordered_quantity + $parameter['quantity'];
                $orderedProduct->increment('orders');
                $orderedProduct->update([
                    'ordered_quantity' => $orderedQuantity,
                ]);
            } else {
                OrderedProduct::query()->create([
                    'product_id'       => $parameter['product']['id'],
                    'orders'           => 1,
                    'ordered_quantity' => $parameter['quantity'],
                ]);
            }
            FlatProduct::query()->where('product_id', (int) $parameter['product']['id'])->increment('sell_count', $parameter['quantity']);
        }
    }
}
