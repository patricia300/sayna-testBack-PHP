<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        DB::table('bills')->insert([
            'date_payment' => $faker->date(),
            'montant_ht' => $faker->numberBetween(1000,50000),
            'montant_ttc' => $faker->numberBetween(1000,50000),
            'source' => $faker->words(),
            'id_stripe' => $faker->randomNumber()
        ]);
        DB::table('bills')->insert([
            'date_payment' => $faker->date(),
            'montant_ht' => $faker->numberBetween(1000,50000),
            'montant_ttc' => $faker->numberBetween(1000,50000),
            'source' => $faker->words(),
            'id_stripe' => $faker->randomNumber()
        ]);
        DB::table('bills')->insert([
            'date_payment' => $faker->date(),
            'montant_ht' => $faker->numberBetween(1000,50000),
            'montant_ttc' => $faker->numberBetween(1000,50000),
            'source' => $faker->words(),
            'id_stripe' => $faker->randomNumber()
        ]);
    }
}
