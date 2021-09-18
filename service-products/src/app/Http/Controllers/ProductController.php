<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductException;
use App\Services\APIResponse;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Find a Product
     *
     * @param $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function show($product_id)
    {
        try {
            //Find the Product
            $productService = new ProductService($product_id);
            $product = $productService->showProduct();
        } catch (ProductException $exception) {
            return APIResponse::errorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }

        return APIResponse::sendResponse(Response::HTTP_OK, $product);
    }

    /**
     * Update a Product
     *
     * @param Request $request
     * @param $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function update(Request $request, $product_id)
    {
        try {
            //Find the Product
            $productService = new ProductService($product_id);

            //Update the product
            $productService->updateProduct(
                $request->price,
                $request->localization ?? []
            );

            //Reload the Product to return updated resource in API - request the same locale type
            $product = (new ProductService($product_id))->showProduct();
        } catch (ProductException $exception) {
            return APIResponse::errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }

        return APIResponse::sendResponse(Response::HTTP_OK, $product, trans('api/product.resource.update.success'));
    }

    /**
     * Update a Product
     *
     * @param $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function delete($product_id)
    {
        try {
            //Find the Product
            $productService = new ProductService($product_id);

            //Delete the product
            $productService->deleteProduct();
        } catch (ProductException $exception) {
            return APIResponse::errorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }

        return APIResponse::sendResponse(Response::HTTP_OK, null, trans('api/product.resource.delete.success'));
    }
}
