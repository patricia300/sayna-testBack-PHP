<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'url' =>$this->faker->url(),
            'cover' => $this->faker->words(),
            'time' => $this->faker->numberBetween(3,10),
            'type' => $this->faker->word
        ];
    }
}
