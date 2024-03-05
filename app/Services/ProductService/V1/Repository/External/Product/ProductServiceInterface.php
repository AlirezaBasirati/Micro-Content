<?php

namespace App\Services\ProductService\V1\Repository\External\Product;

interface ProductServiceInterface
{
    public function storeProductBySAP(array $parameters);
}
