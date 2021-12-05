<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
            
        DB::table('carts')->insert([
            'cartNumber' => $faker->unique()->random_bytes(5),
            'month' => $faker->month(),
            'year' => $faker->year(),
            'default' => $faker->word,
            'user_id' => rand(1,4)
        ]);
        DB::table('carts')->insert([
            'cartNumber' => $faker->randomDigit(),
            'month' => $faker->month(),
            'year' => $faker->year(),
            'default' => $faker->word,
            'user_id' => rand(1,4)
        ]);
        DB::table('carts')->insert([
            'cartNumber' => $faker->randomDigit(),
            'month' => $faker->month(),
            'year' => $faker->year(),
            'default' => $faker->word,
            'user_id' => rand(1,4)
        ]);
        DB::table('carts')->insert([
            'cartNumber' => $faker->randomDigit(),
            'month' => $faker->month(),
            'year' => $faker->year(),
            'default' => $faker->word,
            'user_id' => rand(1,4)
        ]);
        
       
    }
}
