<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Facades\App\Repositories\ColourRepository;

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
        // Available hex colours
        $colours = ColourRepository::get();

        // Tag value
        $tag = ucwords($this->faker->realText(25, 1));

        // Remove all non-numeric
        $tag = preg_replace("/[^A-Za-z0-9]/", '', $tag);

        // Remove all spaces
        $tag = preg_replace("/\s+/", "", $tag);

        $max = count($colours) - 1;

        return [
            'value' => '#' . $tag,
            'hex_colour' => $colours[$this->faker->numberBetween(0, $max)],
        ];
    }
}
