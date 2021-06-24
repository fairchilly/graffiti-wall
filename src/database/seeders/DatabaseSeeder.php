<?php

namespace Database\Seeders;

use App\Models\Post;
//use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Facades\App\Services\TagService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Tag::factory(10)->create();
        Post::factory(100)->create();

        // Handle PostTag pivot table
        $posts = Post::all();
        foreach ($posts as $post) {
            $tags = TagService::extractTags($post->content);

            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    $matched_tag = Tag::where('value', $tag)->first();

                    if ($matched_tag) {
                        $post->tags()->attach($matched_tag);
                        //$post_tag = PostTag::create(['post_id' => $post->id, 'tag_id' => $matched_tag->id]);
                    }
                }
            }
        }
    }
}
