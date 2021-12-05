<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'date_payment' => $this->faker->date(),
        'montant_ht' => $this->faker->numberBetween(1000,50000),
        'montant_ttc' => $this->faker->numberBetween(1000,50000),
        'source' => $this->faker->words(),
        'id_stripe' => $this->faker->randomNumber()
        ];
    }
}
