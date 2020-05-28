<?php

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
    return "Welcome to Aureole Book API";
});

$router->group(['prefix' => 'api'], function ($router) {
    $router->get('external-books', 'BookController@externalBooks');
    $router->group(['prefix' => 'v1/books'], function ($router) {
        $router->get('/', 'BookController@index');
        $router->post('/', 'BookController@store');
        $router->get('/{id:[0-9]+}', 'BookController@show');
        $router->delete('/{id:[0-9]+}', 'BookController@destroy');
        $router->patch('/{id:[0-9]+}', 'BookController@update');
    });
});
