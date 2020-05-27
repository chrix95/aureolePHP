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
    return $router->app->version();
});

// router.post('/', ValidationPolicy.create, BookController.create)
// router.get('/', BookController.read)
// router.get('/:id', BookController.show)
// router.delete('/:id', BookController.destroy)
// router.patch('/:id', ValidationPolicy.update, BookController.update)


// $app->get('/', 'AuthorsController@index');
// $app->post('/', 'AuthorsController@store');
// // $app->get('/{id:[0-9]+}', [
// $app->get('/{id:[\d]+}', [
//     'as' => 'authors.show',
//     'uses' => 'AuthorsController@show'
// ]);
// $app->put('/{id:[\d]+}', 'AuthorsController@update');
// $app->delete('/{id:[\d]+}', 'AuthorsController@destroy');

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
