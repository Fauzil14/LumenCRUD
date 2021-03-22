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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix' => 'api'], function() use ($router) {
    
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    
    $router->get('linkfile', function() {
        return app()->make('files')->link(storage_path('app/public'), rtrim(app()->basePath('public/storage'), '/'));
    });
    
    $router->group(['prefix' => 'product', 'middleware' => 'jwt.auth'], function() use ($router) {
        $router->get('/index', 'ProductController@index');
        $router->get('/show/{product_id}', 'ProductController@show');
        $router->post('/create', 'ProductController@create');
    });

});
