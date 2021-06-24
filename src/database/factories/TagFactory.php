<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Tag value
        $tag = strtolower($this->faker->realText(25, 1));

        // Remove all non-numeric
        $tag = preg_replace("/[^A-Za-z0-9]/", '', $tag);

        // Remove all spaces
        $tag = preg_replace("/\s+/", "", $tag);

        return [
            'value' => '#' . $tag,
        ];
    }
}
