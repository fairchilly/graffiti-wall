<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Repositories\ColourRepository;

class TagService
{
    /**
     * Creates new tags given a post.
     * @param  Post  $post
     * @return Illuminate\Support\Collection
     */
    public function create(Post $post)
    {
        dd('todo');
    }

    /**
     * Returns a list of trending tags.
     * @param  int  $top_count
     * @return Illuminate\Support\Collection
     */
    public function trending(int $top_count)
    {
        $tags = PostTag::selectRaw("tag_id, count(*) as count")
            ->groupBy('tag_id')
            ->orderByDesc('count')
            ->limit($top_count)
            ->get()
            ->map(function($tag) {
                $name = Tag::find($tag->tag_id);
                $tag->name = $name ? $name->value : '#unknown';
                $tag->hex_colour = $name ? $name->hex_colour : '#7a7a7a';

                return $tag;
            });

        return $tags;
    }

    /**
     * Extracts any tags with the format '#XXXXX' found inside a string.
     * @param  string  $content
     * @return array
     */
    public function extractTags(string $content)
    {
        // Pregex match looking for the existance of a #, followed by any number of characters (letter, number, underscore)
        preg_match_all("/#(\\w+)/", $content, $tags);

        return $tags[0];
    }
}
