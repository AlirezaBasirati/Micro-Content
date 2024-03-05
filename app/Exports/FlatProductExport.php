<?php

namespace App\Exports;

use App\Services\ProductService\Models\FlatProduct;
use App\Services\ProductService\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FlatProductExport implements FromCollection, WithHeadings
{

    function __construct(private readonly Collection $flatProducts)
    {
    }

    public function collection(): Collection
    {
        return $this->flatProducts->map(function ($flatProducts) {
            return [
                'name' => $flatProducts->name,
                'sku' => $flatProducts->sku,
                'status' => (string)$flatProducts->status,
                'visibility' => (string)$flatProducts->visibility,
                'is_in_stock' => (string)$flatProducts->is_in_stock,
                'max_in_cart' => (string)$flatProducts->max_in_cart,
                'price_original' => (string)$flatProducts->price_original,
                'price_promoted' => (string)$flatProducts->price_promoted,
                'brand' => $flatProducts->brand?->name,
                'category' => Arr::first($flatProducts->categories)['title'] ?? '',
                'has_image' => count($flatProducts->images ?? []) > 0 ? '1' : '0',
                'has_description' => !is_null($flatProducts->description) ? '1' : '0',
                'has_seo' => !is_null($flatProducts->meta_title) && !is_null($flatProducts->meta_keywords) && !is_null($flatProducts->meta_description) ? '1' : '0',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'name',
            'sku',
            'status',
            'visibility',
            'is_in_stock',
            'max_in_cart',
            'price_original',
            'price_promoted',
            'brand',
            'category',
            'has_image',
            'has_description',
            'has_seo'
        ];
    }
}
