<?php

namespace App\Tests;

use App\Models\Product;
use App\Services\ProductService;

class UpdateProductTest extends TestCase
{
    /**
     * Example Update data
     *
     * @return array
     */
    private function exampleUpdateData()
    {
        return [
            'locale' => 'en-gb',
            'product_id' => 1,
            'product_name' => 'updated name',
            'product_desc' => 'updated description',
            'product_category' => 'updated category',
        ];
    }

    /**
     * Example data for new locale row
     *
     * @return array
     */
    private function exampleNewLocaleUpdateData()
    {
        return [
            'locale' => 'de-de',
            'product_id' => 1,
            'product_name' => 'DE-updated name',
            'product_desc' => 'updated description',
            'product_category' => 'updated category',
        ];
    }

    /**
     * Test Updating only the price
     *
     * @return void
     */
    public function testUpdateProductOnlyPrice($id = 1, $price = 7.99)
    {
        $productService = new ProductService($id, false);
        $productService->updateProduct($price, [])
            ->showProduct();

        //Get the new updated row
        $productService = new ProductService($id);
        $product = $productService->showProduct();


        $this->assertEquals($price, $product->product_price);
    }

    /**
     * Test Updating with same Locale
     *
     * @return void
     */
    public function testUpdateProductSameLocale($id = 1, $price = 15.40)
    {
        //Example request data
        $example_translation_data = $this->exampleUpdateData();

        //Set the locale to the same as the update request
        app()->setLocale($example_translation_data['locale']);

        //Perform Update
        $productService = new ProductService($id, false);
        $product = $productService->updateProduct($price, $example_translation_data)
            ->showProduct();

        $this->assertInstanceOf(Product::class, $product);

        //Get the new updated row
        $productService = new ProductService($id);
        $product = $productService->updateProduct($price, $example_translation_data)
            ->showProduct();

        //Check price is updated
        $this->assertEquals($price, $product->product_price);


        $updated_product_translation_data = $product->translation->toArray();

        //Check product name is updated
        $this->assertEquals($example_translation_data['locale'], $updated_product_translation_data['locale']);
        $this->assertEquals(
            $example_translation_data['product_name'],
            $updated_product_translation_data['product_name']
        );
        $this->assertEquals(
            $example_translation_data['product_desc'],
            $updated_product_translation_data['product_desc']
        );
        $this->assertEquals(
            $example_translation_data['product_category'],
            $updated_product_translation_data['product_category']
        );
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateProductSaveInDiffLocale($id = 1, $price = 15.00)
    {
        //Set the locale to the same as the update request
        app()->setLocale('en-gb');

        //Example request data
        $example_translation_data = $this->exampleNewLocaleUpdateData();

        //Perform Update
        $productService = new ProductService($id, false);
        $product = $productService->updateProduct($price, $example_translation_data)
            ->showProduct();

        //Refresh the product
        $productService = new ProductService($id);
        $product = $productService->showProduct();

        $this->assertInstanceOf(Product::class, $product);
        //Check price is updated
        $this->assertEquals($price, $product->product_price);

        //Check if new locale is in DB
        $this->seeInDatabase('product_translations', [
            'locale' => $example_translation_data['locale'],
            'product_id' => $id,
            'product_name' => $example_translation_data['product_name']
        ]);
    }
}
