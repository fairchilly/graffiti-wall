<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\Posts\PostCollection;
use App\Http\Resources\Posts\PostDetailResource;
use App\Models\Post;
use App\Services\PostService;
use App\Services\TagService;

class PostController extends Controller
{
    /**
     * The post and tag service implementation.
     *
     * @var PostService
     * @var TagService
     */
    protected $posts;
    protected $tags;

    /**
     * Create a new controller instance.
     *
     * @param  PostService  $posts
     * @param  TagService   $tags
     * @return void
     */
    public function __construct(PostService $posts, TagService $tags)
    {
        $this->posts = $posts;
        $this->tags = $tags;
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
     * Creates a new post, and any tags (if applicable).
     * @param  StorePostRequest  $request
     * @return PostResource
     */
    public function create(StorePostRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the post, if valid
        $post = $this->posts->create($request->all());

        // Create the tags, if needed
        $tags = $this->tags->create($post);

        return new PostResource($post);
    }

    /**
     * Returns the full details of a post.
     * @param  Post  $post
     * @return PostResource
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
     * @return PostResource
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
