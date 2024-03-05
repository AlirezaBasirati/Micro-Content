<?php

namespace App\Services\ProductService\V1\Enumerations\Product;

enum Type: string
{
    case SIMPLE = 'simple';
    case CONFIGURABLE = 'configurable';
    case VARIANT = 'variant';
    case BUNDLE = 'bundle';
}
