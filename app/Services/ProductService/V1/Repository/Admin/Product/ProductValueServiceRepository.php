<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use App\Services\ProductService\V1\Models\ProductValue;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

class ProductValueServiceRepository extends BaseRepository implements ProductValueServiceInterface
{
    #[Pure] public function __construct(ProductValue $model)
    {
        parent::__construct($model);
    }

    public function storeMany(array $parameters): void
    {
        DB::beginTransaction();

        foreach ($parameters as $product_value) {
            $this->model->query()->create($product_value);
        }

        DB::commit();
    }
}
