<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'ku' => 'گۆشت',
            'ar' => 'لحم',
            'en' => 'Meat',
            'desc_ku' => 'وەسفی گۆشت',
            'desc_ar' => 'وصف اللحم',
            'desc_en' => 'Description of Meat',
            'subcategory_id' => 1, // Assuming 1 is a valid subcategory_id
            'price' => 10000,
            'discount' => 10,
            'visible' => true,
        ]);

        Item::create([
            'ku' => 'بەڕەنج',
            'ar' => 'أرز',
            'en' => 'Rice',
            'desc_ku' => 'وەسفی بەڕەنج',
            'desc_ar' => 'وصف الأرز',
            'desc_en' => 'Description of Rice',
            'subcategory_id' => 2, // Assuming 2 is a valid subcategory_id
            'price' => 5000,
            'discount' => 5,
            'visible' => true,
        ]);
    }
}
