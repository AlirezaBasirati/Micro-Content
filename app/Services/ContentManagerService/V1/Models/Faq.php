<?php

namespace App\Services\ContentManagerService\V1\Models;

use App\Services\ContentManagerService\V1\Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'question',
        'answer',
        'status',
    ];

    protected static function newFactory(): FaqFactory
    {
        return FaqFactory::new();
    }
}
