<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     * Returns a list of posts authored by a particular user.
     * @param  User  $user
     * @return Collection
     */
    public function posts(User $user)
    {
        return $this->posts->listByUser($user);
    }
}
