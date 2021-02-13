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

$router->get('/', function () use ($router) {
    return \App\Models\Admin::all();
});
$router->put('/', function () use ($router) {
    return \App\Models\Admin::all();
});

$router->group(['prefix' => 'api/v2/'], function () use($router){

    $router->group(['middleware' => 'auth', 'prefix' => 'estabelecimentos'], function () use($router){

        $router->get('/{store_id}', 'StoreController@Find');
    
        $router->get('/{store_id}/Clientes', 'StoreController@ListClients');
        $router->get('/{store_id}/clientes', 'StoreController@ListClients');

        $router->post('/{store_id}/clientes', 'StoreController@PostClients');
        $router->post('/{store_id}/Clientes', 'StoreController@PostClients');
    
        $router->get('/{store_id}/clientes/{client_id}', 'StoreController@FindClient');
        $router->get('/{store_id}/Clientes/{client_id}', 'StoreController@FindClient');

        $router->put('/{store_id}/Clientes/{client_id}/', 'StoreController@UpdClient');
        $router->put('/{store_id}/clientes/{client_id}/', 'StoreController@UpdClient');

    });
    
    $router->group(['prefix' => 'login'], function () use($router){
    
        $router->post('/', ['uses'=>'AdminController@Login']);
    
    });
    
});

