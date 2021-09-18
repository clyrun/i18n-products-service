<?php
namespace App\Tests;

use App\Services\ProductService;
use App\Exceptions\ProductExceptions\ProductNotFound;

class DeleteProductTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteProduct($id = 1)
    {
        $productService = new ProductService($id);
        $productService->deleteProduct();

        //Check if the Product is soft-deleted
        $this->seeInDatabase('products', [
            'product_id' => $id,
        ]);

        //Reload the Product and expect not to be found
        $this->expectException(ProductNotFound::class);
        $productService = new ProductService($id);
        $productService->showProduct();
    }
}
