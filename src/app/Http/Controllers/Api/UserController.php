<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Posts\PostCollection;
use App\Models\User;
use App\Services\PostService;

class UserController extends Controller
{
    /**
     * The post service implementation.
     *
     * @var PostService
     */
    protected $posts;

    /**
     * Create a new controller instance.
     *
     * @param  PostService  $posts
     * @return void
     */
    public function __construct(PostService $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Returns a list of posts authored by a particular username.
     * @param  string  $user
     * @return Collection
     */
    public function posts(string $username)
    {
        $posts =  $this->posts->listByUsername($username);
        
        return new PostCollection($posts);
    }
}
