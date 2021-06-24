<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the user for this post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tags for this post.
     */
    public function tags()
    {
        return $this->hasManyThrough(Tag::class, PostTag::class, 'post_id', 'id');
    }
}
