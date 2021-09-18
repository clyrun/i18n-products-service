<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 *  API Routes
 */
$router->group(['prefix' => 'api/{locale}', 'middleware' => 'Localization'], function () use ($router) {
    /**
     * Product Routes
     */
    $router->group(['prefix' => '/product'], function () use ($router) {
        //Retrieve a Product
        $router->get('/{product_id}', ['uses' => 'ProductController@show']);

        //Update a Product
        $router->patch('/{product_id}', ['uses' => 'ProductController@update']);

        //Delete a Product
        $router->delete('/{product_id}', ['uses' => 'ProductController@delete']);
    });
});
