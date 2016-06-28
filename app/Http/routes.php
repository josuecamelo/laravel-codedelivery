<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    return view('welcome');
});

Route::group(['prefix'=> 'admin', 'middleware' => 'auth.checkrole:admin','as'=> 'admin.'], function() use ($router) {
    $router->group(['prefix' => 'categories', 'as' => 'categories.'], function() use ($router){
        $router->get('/',['uses' => 'CategoriesController@index', 'as' => 'index']);
        $router->get('/create', ['uses' => 'CategoriesController@create', 'as' => 'create']);
        $router->post('/store', ['uses' => 'CategoriesController@store', 'as' => 'store']);
        $router->get('/edit/{id}', ['uses' => 'CategoriesController@edit', 'as' => 'edit']);
        $router->post('/update/{id}', ['uses' => 'CategoriesController@update', 'as' => 'update']);
    });

    $router->group(['prefix' => 'products', 'as' => 'products.'], function() use ($router){
        $router->get('/',['uses' => 'ProductsController@index', 'as' => 'index']);
        $router->get('/create', ['uses' => 'ProductsController@create', 'as' => 'create']);
        $router->post('/store', ['uses' => 'ProductsController@store', 'as' => 'store']);
        $router->get('/edit/{id}', ['uses' => 'ProductsController@edit', 'as' => 'edit']);
        $router->post('/update/{id}', ['uses' => 'ProductsController@update', 'as' => 'update']);
        $router->get('/destroy/{id}', ['uses' => 'ProductsController@destroy', 'as' => 'destroy']);
    });

    $router->group(['prefix' => 'clients', 'as' => 'clients.'], function() use ($router){
        $router->get('/',['uses' => 'ClientsController@index', 'as' => 'index']);
        $router->get('/create', ['uses' => 'ClientsController@create', 'as' => 'create']);
        $router->post('/store', ['uses' => 'ClientsController@store', 'as' => 'store']);
        $router->get('/edit/{id}', ['uses' => 'ClientsController@edit', 'as' => 'edit']);
        $router->post('/update/{id}', ['uses' => 'ClientsController@update', 'as' => 'update']);
        $router->get('/destroy/{id}', ['uses' => 'ClientsController@destroy', 'as' => 'destroy']);
    });

    $router->group(['prefix' => 'orders', 'as' => 'orders.'], function() use ($router){
        $router->get('/',['uses' => 'OrdersController@index', 'as' => 'index']);
        $router->get('/edit/{id}',['uses' => 'OrdersController@edit', 'as' => 'edit']);
        $router->post('/update/{id}',['uses' => 'OrdersController@update', 'as' => 'update']);
    });

    $router->group(['prefix' => 'cupoms', 'as' => 'cupoms.'], function() use ($router){
        $router->get('/',['uses' => 'CupomsController@index', 'as' => 'index']);
        $router->get('/create', ['uses' => 'CupomsController@create', 'as' => 'create']);
        $router->post('/store', ['uses' => 'CupomsController@store', 'as' => 'store']);
        $router->get('/edit/{id}', ['uses' => 'CupomsController@edit', 'as' => 'edit']);
        $router->post('/update/{id}', ['uses' => 'CupomsController@update', 'as' => 'update']);
        $router->get('/destroy/{id}', ['uses' => 'CupomsController@destroy', 'as' => 'destroy']);
    });
});

Route::group(['prefix' => 'customer', 'as' => 'customer.','middleware' => 'auth.checkrole:client'], function() use($router){
    $router->get('order', ['as' => 'order.index', 'uses' => 'CheckoutController@index']);
    $router->get('order/create', ['as' => 'order.create', 'uses' => 'CheckoutController@create']);
    $router->post('order/store', ['as' => 'order.store', 'uses' => 'CheckoutController@store']);
});
