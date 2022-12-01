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
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', ['uses'=> 'authController@register']);
    $router->post('/login', ['uses'=> 'authController@login']);
});

$router->group(['prefix' => 'prodi'], function () use ($router) {
    $router->get('/', ['uses'=> 'prodiController@prodi']);
});

// router->group(['prefix' => 'matakuliah'], function () use ($router) {
//     $router->get('/', ['uses'=> 'matakuliahController@getallmk']);
// });

$router->group(['prefix' => 'mahasiswa'], function () use ($router) {
    $router->get('/', ['uses'=> 'mahasiswaController@getallmhs']);
    $router->get('/profile', ['middleware' => 'jwt.auth','uses'=> 'mahasiswaController@getmhstoken']);
    $router->get('/{nim}', ['uses'=> 'mahasiswaController@getmhs']);
});
