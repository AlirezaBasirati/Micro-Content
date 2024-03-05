<?php

namespace App\Services\ProductService\V1\Repository\Client\FlatProduct;

use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface FlatProductServiceInterface extends BaseRepositoryInterface
{
    public function filter(array $queries = []): array;

    public function leach(array $queries = []): array;

    public function listBySkuAndStore(array $items): Collection;

    public function listByIdAndStore(array $items): Collection;

    public function findBySku(array $parameter): ?Model;

    public function mapper(Product $product, array $only = []): array;

    public function make(array $parameter, array $only = []);

    public function modifyStock(array $parameter, FlatProduct $flatProduct);

    public function syncInventory(array $parameters): void;

    public function saveFlatProduct(array $parameter): void;

    public function showBySku(string $sku): ?Collection;

    public function fetch(array $parameters): FlatProduct;

    public function massCreationFlatCategory(Collection $flatCategories): void;

    public function search($parameters): LengthAwarePaginator;

    public function recentSearches($parameters): Collection;

    public function popularSearches(): array;
    public function menuByAttribute(): array;
    public function createMenuByAttribute(): array;
}
