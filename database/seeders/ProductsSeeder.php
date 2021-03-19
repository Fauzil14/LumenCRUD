<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [ "7118441101378", 2, "ABC", "ABC KECAP MANIS POUCH 600ML" ],
            [ "8991002101654", 5, "ABC", "ABC KOPI SUSU BAG 20X32G" ],
            [ "711844330207", 2, "ABC", "ABC MACKEREL TOMATO 155GR" ],
            [ "711844120013", 4, "ABC", "ABC SAMBAL ASLI 340ML" ],
            [ "711844120075", 4, "ABC", "ABC SAMBAL EXTRA PEDAS 415ML" ],
            [ "711844120099", 4, "ABC", "ABC SAMBAL MANIS PEDAS 415ML" ],
            [ "711844130012", 4, "ABC", "ABC TOMATO KETCHUP 340ML" ],
            [ "9415007006329", 5, "ANLENE", "ANLENE MILK ACTIFIT 600 GR" ],
            [ "9415007009146", 5, "ANLENE", "ANLENE MILK GOLD 51+ 600 ML" ],
            [ "8992779022203", 6, "AXI", "AXI PEMBERSIH LANTAI APPLE GREEN POUCH 800ML" ],
            [ "8993169221008", 2, "AYAM JAGO", "AYAM JAGO BERAS WANGI BIRU 10 KG",  ],
            [ "8993169762051", 2, "AYAM JAGO", "AYAM JAGO BERAS WANGI BIRU 5 KG",  ],
        ];

        foreach( $seeds as $seed ) {
            Product::updateOrCreate([
                'product_code' => $seed[0],
            ],[
                'category_id' => $seed[1],
                'brand' => $seed[2],
                'product_name' => $seed[3],
                'stock' => rand(0, 20),
            ]);
        } 
    }
}
