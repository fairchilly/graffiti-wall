<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;

class PostService
{
    /**
     * Returns a list of posts.
     *
     * @return Illuminate\Support\Collection
     */
    public function list()
    {
        $posts = Post::with('user')
            ->orderByDesc('created_at')
            ->simplePaginate(15);

        return $posts;
    }

    /**
     * Returns a list of posts authored by a particular user.
     * @param  User  $user
     * @return Illuminate\Support\Collection
     */
    public function listByUser(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->simplePaginate(15);

        return $posts;
    }

    /**
     * Returns a list of posts containing a particular tag.
     * @param  string  $tag
     * @return Illuminate\Support\Collection
     */
    public function listByTag(string $tag)
    {
        // Trim, lowercase, and prepend a #
        $tag = trim(strtolower($tag));
        $tag = substr($tag, 0, 1) !== '#' ? '#' . $tag : $tag;
        $tag_object = Tag::whereRaw('lower(`value`) like ?', ["%$tag%"])->first();

        $posts = [];
        if ($tag_object) {
            $post_ids = PostTag::where('tag_id', $tag_object->id)
                ->pluck('post_id')
                ->unique()
                ->toArray();

            if (count($post_ids) > 0) {
                $posts = Post::whereIn('id', $post_ids)
                    ->orderByDesc('created_at')
                    ->simplePaginate(15);
            }
        }

        return $posts;
    }

    /**
     * Finds an existing post.
     * @param  int  $post_id
     * @return Illuminate\Support\Collection
     */
    public function findById(int $post_id)
    {
        $post = Post::with('user', 'tags')
            ->find($post_id);

        return $post;
    }

    /**
     * Creates a new post.
     * @param  array  $request
     * @return Illuminate\Support\Collection
     */
    public function create(array $request)
    {
        $post = Post::create($request);

        return $post;
    }

    /**
     * Updates an existing post.
     * @param  Post   $post
     * @param  array  $request
     * @return Illuminate\Support\Collection
     */
    public function update(Post $post, array $request)
    {
        // User ids don't match, unauthorized
        if ($post->user_id !== auth()->user()->id) {
            return false;
        }

        $post->fill($request);
        $post->save();

        return true;
    }

    /**
     * Delete an existing post.
     * @param  Post   $post
     * @return boolean
     */
    public function delete(Post $post)
    {
        // User ids don't match, unauthorized
        if ($post->user_id !== auth()->user()->id) {
            return false;
        }

        $post->delete();

        return true;
    }

    /**
     * Returns a counted archive summary of posts, grouped by year and month.
     * @param  int  $limit
     * @return Illuminate\Support\Collection
     */
    public function archiveSummary(int $limit = 24)
    {
        $summary = Post::selectRaw("max(date_format(created_at, '%Y%m')) as date,
                date_format(created_at, '%Y') as year,
                date_format(created_at, '%M') as month,
                count(*) as count")
            ->groupBy('year')
            ->groupBy('month')
            ->orderByDesc('date')
            ->limit($limit)
            ->get();

        return $summary;
    }
}
