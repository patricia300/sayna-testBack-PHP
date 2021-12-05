<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        DB::table('users')->insert([
            'firstname' => $faker->firstName(),
            'lastname' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'date_naissance' => $faker->date(),
            'sexe' => "masculin",
            'role' => 'simple_user',
            'cart_id' => rand(2,4),
            'subscription' => 0
        ]);

        DB::table('users')->insert([
            'firstname' => $faker->firstName(),
            'lastname' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'date_naissance' => $faker->date(),
            'sexe' => "féminin",
            'role' => 'subscriber',
            'cart_id' => rand(1,2),
            'bill_id' => rand(1,3),
            'subscription' => 1
        ]);
    }
}
