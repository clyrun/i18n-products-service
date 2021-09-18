<?php
namespace App\Tests;

use App\Models\Product;
use App\Services\ProductService;
use App\Exceptions\ProductException;
use App\Exceptions\ProductExceptions\ProductTranslationNotFound;

class GetProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProduct($id = 1)
    {
        $productService = new ProductService($id);
        $product = $productService->showProduct();


        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($id, $product->product_id);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProductwithCapitalisation($id = 1, $lang = 'Fr-Ch')
    {
        app()->setLocale($lang);

        $productService = new ProductService($id);
        $product = $productService->showProduct();

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($id, $product->product_id);
        $this->assertEquals(strtolower($lang), $product->translation->locale);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProductwithENGB($id = 1, $lang = 'en-gb')
    {
        app()->setLocale($lang);

        $productService = new ProductService($id);
        $product = $productService->showProduct();

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($id, $product->product_id);
        $this->assertEquals($lang, $product->translation->locale);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProductwithFRCH($id = 1, $lang = 'fr-ch')
    {
        app()->setLocale($lang);

        $productService = new ProductService($id);
        $product = $productService->showProduct();

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($id, $product->product_id);
        $this->assertEquals($lang, $product->translation->locale);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProductwithNoTranslationRow($id = 1, $lang = 'en-ch')
    {
        app()->setLocale($lang);
        $this->expectException(ProductTranslationNotFound::class);
        $productService = new ProductService($id);
        $product = $productService->showProduct();

        $this->assertInstanceOf(ProductException::class, $product);
        $this->assertEquals($id, $product->product_id);
    }
}
