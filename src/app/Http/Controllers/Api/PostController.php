<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\Posts\PostCollection;
use App\Http\Resources\Posts\PostDetailResource;
use App\Models\Post;
use App\Services\PostService;


use Facades\App\Services\TagService;

class PostController extends Controller
{
    /**
     * The post and tag service implementation.
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
     * Returns a list of posts.
     *
     * @return PostCollection
     */
    public function list()
    {
        $posts = $this->posts->list();

        return new PostCollection($posts);
    }

    /**
     * Searches for posts that were created on a specific year and month.
     * @param  int  $year
     * @param  int  $month
     * @return PostCollection
     */
    public function listByYearAndMonth(int $year, int $month)
    {
        $posts = $this->posts->findByYearAndMonth($year, $month);

        return new PostCollection($posts);
    }

    /**
     * Creates a new post, and any tags (if applicable).
     * @param  StorePostRequest  $request
     * @return PostDetailResource
     */
    public function create(StorePostRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the post, if valid
        $post = $this->posts->create($request->all());

        return new PostDetailResource($post);
    }

    /**
     * Returns the full details of a post.
     * @param  Post  $post
     * @return PostDetailResource
     */
    public function details(Post $post)
    {
        $post = $this->posts->findById($post->id);
        
        return new PostDetailResource($post);
    }

    /**
     * Updates an existing post with new data.
     * @param  Post  $post
     * @param  StorePostRequest  $request
     * @return void
     */
    public function update(Post $post, StorePostRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Update the post, if valid
        $updated = $this->posts->update($post, $request->all());

        // An error occurred, unauthorized
        if (!$updated) {
            return response('Unauthorized', 401);
        } else {

            // Update the tags, if needed
            $tags = $this->tags->create($post);
        }

        // Successful
        return response(null, 204);
    }

    /**
     * Deletes an existing post.
     * @param  Post  $post
     * @return void
     */
    public function delete(Post $post)
    {
        $deleted = $this->posts->delete($post);

        // An error occurred, unauthorized
        if (!$deleted) {
            return response('Unauthorized', 401);
        }

        // Successful
        return response(null, 204);
    }

    /**
     * Returns a counted archive summary of posts, grouped by year and month.
     *
     * @return Illuminate\Support\Collection
     */
    public function archiveSummary()
    {
        return $this->posts->archiveSummary();
    }
}
