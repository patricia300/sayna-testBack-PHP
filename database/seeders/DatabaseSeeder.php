<?php

namespace Database\Seeders;

use App\Models\Bill;
use Database\Factories\CartFactory;
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
        $this->call([
            UserSeeder::class,
            // CartSeeder::class,
            // BillSeeder::class,
            SongSeeder::class
        ]);
    }
}
