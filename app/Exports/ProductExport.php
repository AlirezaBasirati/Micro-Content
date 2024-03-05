<?php

namespace App\Exports;

use App\Services\ProductService\V1\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection
{
    protected array $parameters;

    function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function collection(): Collection
    {
        $products = Product::query()->with(['brand', 'categories']);

        if (isset($this->parameters['category_id'])) {
            $products = $products->whereHas('categories', function (Builder $query) {
                $query->where('category_id', $this->parameters['category_id']);
            });
        }

        if (isset($this->parameters['brand_id'])) {
            $products = $products->where('brand_id', $this->parameters['brand_id']);
        }

        if (isset($this->parameters['visibility'])) {
            $products = $products->where('visibility', $this->parameters['visibility']);
        }

        if (isset($this->parameters['status'])) {
            $products = $products->where('status', $this->parameters['status']);
        }
//
//        if (isset($this->parameters['description'])) {
//            if ($this->parameters['description'] == 1) {
//                $products = $products->whereNotNull('description');
//            } else {
//                $products = $products->whereNull('description');
//            }
//        }
//
//        if (isset($this->parameters['seo'])) {
//            if ($this->parameters['seo'] == 1) {
//                $products = $products->whereNotNull(['meta_title', 'meta_keywords', 'meta_description']);
//            } else {
//                $products = $products->whereNull(['meta_title', 'meta_keywords', 'meta_description']);
//            }
//        }
//
//        if (isset($this->parameters['image'])) {
//            if ($this->parameters['image'] == 1) {
//                $products = $products->whereHas('images');
//            } else {
//                $products = $products->whereDoesntHave('image');
//            }
//        }

        $products = $products->get();

        return $products->map(function ($products) {
            return [
                'sku'        => $products->sku,
                'name'       => $products->name,
                'visibility' => $products->visibility,
                'tax_class'  => $products->tax_class,
                'barcode'    => $products->barcode,
                'brand'      => $products->brand->slug,
                'categories' => $products->categories->implode('slug', '|'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'sku',
            'name',
            'visibility',
            'tax_class',
            'barcode',
            'brand',
            'categories',
        ];
    }
}
