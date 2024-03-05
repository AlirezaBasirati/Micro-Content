<?php

namespace App\Services\ContentManagerService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'topic',
        'name',
        'email',
        'phone',
        'description',
    ];
}
