<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\PostService;
use App\Services\TagService;

class TagController extends Controller
{
    /**
     * The tag and post service implementation.
     *
     * @var TagService
     * @var PostService
     */
    protected $tags;
    protected $posts;

    /**
     * Create a new controller instance.
     *
     * @param  TagService  $tags
     * @param  PostService  $tags
     * @return void
     */
    public function __construct(TagService $tags, PostService $posts)
    {
        $this->tags = $tags;
        $this->posts = $posts;
    }

    /**
     * Returns a list of trending tags.
     * @param  int  $top_count
     * @return Illuminate\Support\Collection
     */
    public function trending(int $top_count = 5)
    {
        return $this->tags->trending($top_count);
    }

    /**
     * Creates a new tag.
     * @param  string  $tag
     * @return Tag
     */
    public function add(string $tag)
    {
        // Creates the tag if it doesn't already exists, or return the existing tag
        $tag = Tag::firstOrCreate(
            ['value' => $tag]
        );
        
        return $tag;
    }

    /**
     * Returns a list of posts using a particular tag.
     * @param  string  $tag
     * @return Collection
     */
    public function posts(string $tag)
    {
        return $this->posts->listByTag($tag);
    }
}
