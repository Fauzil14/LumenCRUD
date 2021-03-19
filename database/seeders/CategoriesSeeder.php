<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = [
            /* 1 */    [ 'category_name' => 'alat tulis' ], 
            /* 2 */    [ 'category_name' => 'sembako' ], 
            /* 3 */    [ 'category_name' => 'peralatan mandi dan mencuci' ], 
            /* 4 */    [ 'category_name' => 'jajanan dan makanan ringan' ], 
            /* 5 */    [ 'category_name' => 'minuman' ], 
            /* 6 */    [ 'category_name' => 'perlengkapan rumah tangga' ], 
            /* 7 */    [ 'category_name' => 'obat-obatan' ], 
            /* 8 */    [ 'category_name' => 'gas elpiji' ], 
            /* 9 */    [ 'category_name' => 'keperluan bayi' ], 
            /* 10 */   [ 'category_name' => 'lain-lain' ], 
            ];

        DB::table('categories')->insert($seed);
    }
}
