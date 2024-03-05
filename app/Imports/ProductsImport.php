<?php

namespace App\Imports;

use App\Services\ProductService\V1\Enumerations\Attribute\Attribute;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Repository\Admin\Product\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct(private readonly ProductServiceInterface $productService)
    {
    }

    public function collection(Collection $collection): void
    {
        DB::beginTransaction();

        foreach ($collection as $row) {
            $parameters = [
                'brand_id'         => Brand::query()->where('slug', $row['brand'])->first()->id,
                'name'             => $row['name'],
                'sku'              => $row['sku'],
                'public_id'        => $row['public_id'],
                'url_key'          => $row['sku'],
                'barcode'          => $row['barcode'],
                'status'           => $row['status'],
                'tax_class'        => $row['tax_class'],
                'visibility'       => (int)($row['visibility'] ?? 1),
                'meta_description' => $row['properties'] ?? null,
                'description'      => $row['desc'] ?? null,
            ];

            $categories = Category::query()->where('slug', $row['category'])->pluck('id')->toArray();
            if (count($categories)) {
                $parameters['categories'] = $categories;
            }

            $parameters['attribute_value_ids'] = [];


            if (isset($row['color']) && $row['color'] != '') {
                $this->calculateAttributes($parameters['attribute_value_ids'], $row['color'], Attribute::COLOR);
            }

            if (isset($row['size']) && $row['size'] != '') {
                $this->calculateAttributes($parameters['attribute_value_ids'], $row['size'], Attribute::SIZE);
            }

            if (isset($row['type']) && $row['type'] != '') {
                $this->calculateAttributes($parameters['attribute_value_ids'], $row['type'], Attribute::TYPE);
            }

            $this->productService->extendedCreate($parameters);

            DB::commit();
        }
    }

    private function calculateAttributes(&$attributeValues, $values, Attribute $type): void
    {
        $items = explode('-', $values);

        foreach ($items as $item) {
            $attributeValues[] = AttributeValue::query()->updateOrCreate([
                'value' => $item
            ], [
                'attribute_id' => $type->value
            ])->id;
        }
    }

    public function rules(): array
    {
        return [
            'brand'        => 'required',
            '*.brand'      => Rule::exists('brands', 'slug'),
            'name'         => 'required',
            '*.name'       => 'string',
            'sku'          => 'required',
            '*.sku'        => Rule::unique('products', 'sku'),
            'public_id'    => 'required',
            '*.public_id'  => 'integer',
            'url_key'      => 'required',
            '*.url_key'    => 'string',
            'barcode'      => 'required',
            '*.barcode'    => 'integer',
            'status'       => 'required',
            '*.status'     => 'integer',
            'tax_class'    => 'required',
            '*.tax_class'  => 'integer',
            'visibility'   => 'required',
            '*.visibility' => 'boolean',
            'category'     => 'required',
            '*.category'   => Rule::exists('categories', 'slug'),
            'color'        => 'nullable',
            'size'         => 'nullable',
            'properties'   => 'nullable',
            'desc'         => 'nullable|string',
        ];
    }
}
