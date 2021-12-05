<?php

namespace Database\Seeders;

use App\Models\Song;
use Database\Factories\SongFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('songs')->insert([
            'name' => 'Nui raza',
            'url' => 'https://www.youtube.com/watch?v=xK-AvS-effs',
            'cover' => 'original',
            'time' => '03:50',
            'type' => 'jazz'
        ]);
    }
}
