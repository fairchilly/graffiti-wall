<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Make some anonymous, make some attached to a user
        $is_anonymous = $this->faker->numberBetween(0, 1) === 1 ? true : false;

        // Add paragraph markup to each paragraph
        $paragraphs = $this->faker->paragraphs($nb = 3, $asText = false);
        $content = '';

        foreach ($paragraphs as $paragraph) {
            $content .= '<p>' . $paragraph . '</p>';
        }

        // Apply some random tags (2 per post)
        $all_tags = Tag::all()->toArray();
        $tag_id_1 = $this->faker->numberBetween(1, 5);
        $tag_id_2 = $this->faker->numberBetween(1, 5);

        // Finally, add tags to the end of the content
        $content .= '<p>' . $all_tags[$tag_id_1]['value'] . ' ' . $all_tags[$tag_id_2]['value'] . '</p>';

        // Randomized date
        $date = $this->faker->dateTimeThisDecade();

        return [
            'user_id' => $is_anonymous ? null : $this->faker->numberBetween(1, 10),
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'content' => $content,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
