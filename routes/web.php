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

//get user by token
$router->group(['prefix' => 'user'], function() use ($router) {
    $router->get('/', ['middleware' => 'jwt.auth','uses' => 'userController@getUserbyToken']);
});

//note
$router->group(['prefix' => 'note'], function() use ($router) {
    //get all note
    $router->get('/',['middleware' => 'jwt.auth','uses' => 'noteController@getAllNote']);
    //addnote
    $router->post('/add', ['middleware' => 'jwt.auth','uses' => 'noteController@addNote']);
    //delete note
    $router->delete('/delete/{id}',['middleware' => 'jwt.auth','uses' => 'noteController@deleteNote']);
    //update note
    $router->put('update/{id}',['middleware' => 'jwt.auth','uses' => 'noteController@updateNote']);
});

//end point
//post register
//post login
//post add note
//get user from token
//get all note
//get note from id note
//delete note
//put update note
