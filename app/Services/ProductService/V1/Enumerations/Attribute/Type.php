<?php

namespace App\Services\ProductService\V1\Enumerations\Attribute;

enum Type: string
{
    case COLOR = 'color';
    case TEXT = 'text';
    case NUMBER = 'number';
    case BOOLEAN = 'boolean';
    case HTML = 'html';
    case DATE = 'date';
}
