<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'ku' => 'ماكدونالدز',
                'ar' => 'ماكدونالدز',
                'en' => 'McDonald\'s',
                'image' => 'mcdonalds.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'كنتاكي',
                'ar' => 'كنتاكي',
                'en' => 'KFC',
                'image' => 'kfc.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'بيتزا هت',
                'ar' => 'بيتزا هت',
                'en' => 'Pizza Hut',
                'image' => 'pizzahut.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'دومينوز',
                'ar' => 'دومينوز',
                'en' => 'Domino\'s Pizza',
                'image' => 'dominos.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'صب واي',
                'ar' => 'صب واي',
                'en' => 'Subway',
                'image' => 'subway.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
