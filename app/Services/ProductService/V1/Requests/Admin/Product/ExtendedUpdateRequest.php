<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ExtendedUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'            => ['string'],
            'sku'             => ['string'],
            'public_id'       => ['string'],
            'url_key'         => ['string'],
            'visibility'      => ['boolean'],
            'status'          => ['numeric'],
            'images'          => ['array'],
            'delete_images'   => ['array'],
            'images.*'        => ['required', 'file'],
            'delete_images.*' => ['required', 'string'],
            'thumbnail'       => ['file'],
            'tax_class'       => ['string'],
            'categories'      => ['array'],
            'categories.*'    => ['integer'],
            'max_in_cart'     => ['integer'],
            'min_in_cart'     => ['integer'],
            'brand_id'        => ['integer'],
        ];
    }
}
