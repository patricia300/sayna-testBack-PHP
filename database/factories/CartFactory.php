<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'cartNumber' => $this->faker->randomDigit(),
        'month' => $this->faker->month(),
        'year' => $this->faker->year(),
        'default' => $this->faker->word,
        ];
    }
}
