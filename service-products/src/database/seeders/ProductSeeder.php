<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insertOrIgnore([
            [
                'product_id' => 1,
                'product_price' => 19.99
            ],
            [
                'product_id' => 2,
                'product_price' => 10.00
            ],
        ]);
    }
}
