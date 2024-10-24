<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            // McDonald's Categories
            [
                'ku' => 'برغر',
                'ar' => 'برغر',
                'en' => 'Burgers',
                'brand_id' => 1, // McDonald's
                'image' => 'burgers.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'وجبات افطار',
                'ar' => 'وجبات افطار',
                'en' => 'Breakfast Meals',
                'brand_id' => 1, // McDonald's
                'image' => 'breakfast.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KFC Categories
            [
                'ku' => 'دجاج مقلي',
                'ar' => 'دجاج مقلي',
                'en' => 'Fried Chicken',
                'brand_id' => 2, // KFC
                'image' => 'fried_chicken.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'سندويشات',
                'ar' => 'سندويشات',
                'en' => 'Sandwiches',
                'brand_id' => 2, // KFC
                'image' => 'sandwiches.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pizza Hut Categories
            [
                'ku' => 'بيتزا',
                'ar' => 'بيتزا',
                'en' => 'Pizza',
                'brand_id' => 3, // Pizza Hut
                'image' => 'pizza.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'باستا',
                'ar' => 'باستا',
                'en' => 'Pasta',
                'brand_id' => 3, // Pizza Hut
                'image' => 'pasta.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Domino's Categories
            [
                'ku' => 'بيتزا',
                'ar' => 'بيتزا',
                'en' => 'Pizza',
                'brand_id' => 4, // Domino's
                'image' => 'pizza.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'جانبيات',
                'ar' => 'جانبيات',
                'en' => 'Sides',
                'brand_id' => 4, // Domino's
                'image' => 'sides.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Subway Categories
            [
                'ku' => 'ساندويشات',
                'ar' => 'ساندويشات',
                'en' => 'Sandwiches',
                'brand_id' => 5, // Subway
                'image' => 'sandwiches.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'سلطات',
                'ar' => 'سلطات',
                'en' => 'Salads',
                'brand_id' => 5, // Subway
                'image' => 'salads.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
