<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'tag_id',
        'created_at',
        'updated_at',
    ];
}
