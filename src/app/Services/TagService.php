<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;

class TagService
{
    /**
     * Updates tags on a post by both adding and/or deleting.
     * @param  Post  $post
     * @return Post
     */
    public function update(Post $post)
    {
        // Removes any old tags found in the pivot table
        $this->deleteOldTagsRelations($post);

        // Adds any new tags not found in the pivot table
        $this->addNewTagRelations($post);

        // Reload the post
        $post = Post::find($post->id);

        return $post;
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

        $tags = $tags[0];

        // Lowercase tags
        // Ignore tags that are less than 3 characters, or more than 30 chars
        foreach ($tags as $index => $tag) {

            if (strlen($tag) < 3 || strlen($tag) > 30) {
                unset($tags[$index]);
            } else {
                $tags[$index] = strtolower($tag);
            }
        }

        return $tags;
    }

    /**
     * Removes any tags from the post_tag table, that is not found in the post content field
     * @param  Post  $post
     * @return void
     */
    private function deleteOldTagsRelations(Post $post)
    {
        // Get the new tags
        $content_tags = $this->extractTags($post->content);

        // Find the existing tags
        $existing_tags = $post->tags()->get();

        // Remove any existing tags not found in the content
        foreach ($existing_tags as $existing_tag) {

            // Compare
            $exists = in_array($existing_tag->value, $content_tags);

            // Delete tag
            if (!$exists) {
                $post->tags()->detach($existing_tag->id);
            }
        }
    }

    /**
     * Adds any new tags to the post_tag table
     * @param  Post  $post
     * @return void
     */
    private function addNewTagRelations(Post $post)
    {
        // Get the new tags
        $content_tags = $this->extractTags($post->content);

        // Find the existing tags
        $existing_tags = $post->tags()->get();

        // Prep for comparison
        $existing_tags = $existing_tags->pluck('value')->toArray();

        // Filter out any new tags that already exists in the database
        foreach ($content_tags as $index => $content_tag) {

            // Compare
            $exists = in_array($content_tag, $existing_tags);

            // Tag already exists, unset
            if ($exists) {
                unset($content_tags[$index]);
            }
        }

        // Add new tags
        $existing_tags = Tag::select('value')
            ->whereIn('value', $content_tags)
            ->get()
            ->toArray();

        $content_tags = array_diff($content_tags, $existing_tags);

        foreach ($content_tags as $content_tag) {
            $tag = Tag::create(['value' => $content_tag]);
            $post->tags()->attach($tag);
        }
    }
}
