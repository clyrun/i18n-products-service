<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Product 1 Translations
        DB::table('product_translations')->insertOrIgnore([
            [
                'translation_id' => 1,
                'locale' => 'en-gb',
                'product_id' => 1,
                'product_name' => 'EN-GB-Example product',
                'product_desc' => 'EN-GB-Description of product',
                'product_category' => 'EN-GB-Category1',
            ],
            [
                'translation_id' => 2,
                'locale' => 'fr-ch',
                'product_id' => 1,
                'product_name' => 'FR-CH-Example product',
                'product_desc' => 'FR-CH-Description of product',
                'product_category' => 'FR-CH-Category1',
            ],
        ]);

        //Product 2 Translations
        DB::table('product_translations')->insertOrIgnore([
            [
                'translation_id' => 3,
                'locale' => 'en-gb',
                'product_id' => 2,
                'product_name' => 'EN-GB-Another product',
                'product_desc' => 'EN-GB-Second description',
                'product_category' => 'EN-GB-Category2',
            ],
            [
                'translation_id' => 4,
                'locale' => 'fr-ch',
                'product_id' => 2,
                'product_name' => 'FR-CH-Another product',
                'product_desc' => 'FR-CH-Second description',
                'product_category' => 'FR-CH-Category2',
            ],
        ]);
    }
}
