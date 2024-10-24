<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategories')->insert([
            // Subcategories for McDonald's Burgers Category (category_id = 1)
            [
                'ku' => 'برغر دبل',
                'ar' => 'برغر دبل',
                'en' => 'Double Burger',
                'category_id' => 1, // Burgers category for McDonald's
                'image' => 'double_burger.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'بيغ ماك',
                'ar' => 'بيغ ماك',
                'en' => 'Big Mac',
                'category_id' => 1, // Burgers category for McDonald's
                'image' => 'big_mac.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Subcategories for KFC Fried Chicken Category (category_id = 3)
            [
                'ku' => 'دجاج مشوي',
                'ar' => 'دجاج مشوي',
                'en' => 'Grilled Chicken',
                'category_id' => 3, // Fried Chicken category for KFC
                'image' => 'grilled_chicken.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'دجاج مقرمش',
                'ar' => 'دجاج مقرمش',
                'en' => 'Crispy Chicken',
                'category_id' => 3, // Fried Chicken category for KFC
                'image' => 'crispy_chicken.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Subcategories for Pizza Hut Pizza Category (category_id = 5)
            [
                'ku' => 'بيتزا مارغريتا',
                'ar' => 'بيتزا مارغريتا',
                'en' => 'Margherita Pizza',
                'category_id' => 5, // Pizza category for Pizza Hut
                'image' => 'margherita_pizza.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ku' => 'بيتزا بيبروني',
                'ar' => 'بيتزا بيبروني',
                'en' => 'Pepperoni Pizza',
                'category_id' => 5, // Pizza category for Pizza Hut
                'image' => 'pepperoni_pizza.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Additional subcategories for other brands can go here...
        ]);
    }
}
