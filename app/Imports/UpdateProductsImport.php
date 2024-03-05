<?php

namespace App\Imports;

use App\Services\ProductService\V1\Jobs\UpdateProductImport;
use App\Services\ProductService\V1\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UpdateProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @throws ValidationException
     */
    public function collection(Collection $collection): void
    {
        $differences = [];
        $skus = $collection->pluck('sku')->toArray();
        $products = Product::query()->whereIn('sku', $skus)->get(['sku']);
        if ($products->count() != count($skus)) {
            $differences = array_diff($skus, $products->pluck('sku')->toArray());
        }
        foreach ($collection as $item) {
            if (isset($this->item['sku'])) {
                dispatch(new UpdateProductImport($item));
            }
        }
        if (count($differences)) {
            throw ValidationException::withMessages([
                'product' => __('validation.exists', ['attribute' => implode(', ', $differences)])
            ]);
        }
    }
}
