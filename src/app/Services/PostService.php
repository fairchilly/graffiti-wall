<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Facades\App\Services\TagService;

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
     * Returns a list of posts authored by a particular username.
     * @param  string  $username
     * @return Illuminate\Support\Collection
     */
    public function listByUsername(string $username)
    {
        // Special anonymous case
        if (strtolower($username) == 'anonymous') {
            $posts = Post::where('user_id', null)
                ->orderByDesc('created_at')
                ->simplePaginate(15);
        } else {

            $user = User::where('username', $username)->first();

            if ($user) {
                $posts = $user
                    ->posts()
                    ->orderByDesc('created_at')
                    ->simplePaginate(15);
            } else {
                $posts = collect([]);
            }
        }

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
        $existing_tag = Tag::whereRaw('lower(`value`) like ?', ["%$tag%"])->first();

        if ($existing_tag) {
            $posts = $existing_tag
                ->posts()
                ->orderByDesc('created_at')
                ->simplePaginate(15);
        } else {
            $posts = collect([]);
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
     * Finds an posts by the year and month they were created.
     * @param  int  $year
     * @param  int  $month
     * @return Illuminate\Support\Collection
     */
    public function findByYearAndMonth(int $year, int $month)
    {
        $posts = Post::with('user', 'tags')
            ->whereRaw('date_format(created_at, \'%Y\') = ?', [$year])
            ->whereRaw('date_format(created_at, \'%c\') = ?', [$month])
            ->orderBy('created_at')
            ->simplePaginate(15);

        return $posts;
    }

    /**
     * Creates a new post.
     * @param  StorePostRequest  $request
     * @return Illuminate\Support\Collection
     */
    public function create(StorePostRequest $request)
    {
        $fields = $request->all();

        // Check for user authentication
        if ($request->user()) {
            $fields['user_id'] = $request->user()->id;
        }

        // Create the post
        $post = Post::create($fields);

        // Update the tags
        $post = TagService::update($post);

        return $post;
    }

    /**
     * Updates an existing post.
     * @param  Post   $post
     * @param  StorePostRequest  $request
     * @return Illuminate\Support\Collection
     */
    public function update(Post $post, StorePostRequest $request)
    {
        $fields = $request->all();

        $post->fill($fields);
        $post->save();

        // Update the tags
        $post = TagService::update($post);

        return $post;
    }

    /**
     * Delete an existing post.
     * @param  Post   $post
     * @return boolean
     */
    public function delete(Post $post)
    {
        $post->delete();
    }

    /**
     * Returns a counted archive summary of posts, grouped by year and month.
     * @param  int  $limit
     * @return Illuminate\Support\Collection
     */
    public function archiveSummary(int $limit = 24)
    {
        $summary = Post::selectRaw("max(date_format(created_at, '%Y%c')) as date,
                date_format(created_at, '%Y') as year,
                date_format(created_at, '%M') as month,
                max(date_format(created_at, '%c')) as month_number,
                count(*) as count")
            ->groupBy('year')
            ->groupBy('month')
            ->orderByDesc('date')
            ->limit($limit)
            ->get();

        return $summary;
    }
}
