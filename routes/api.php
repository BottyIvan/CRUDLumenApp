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

$router->get('/show/all', 'ProfileController@index');

// Rotte con prefisso 'profile'
$router->group(['prefix' => 'profile'], function () use ($router) {
    // Rotte accessibili pubblicamente
    $router->get('/show[/{id}]', 'ProfileController@show');

    // Gruppo di rotte protette 
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/create', 'ProfileController@create');
        $router->put('/update[/{id}]', 'ProfileController@update');
        $router->delete('/delete[/{id}]', 'ProfileController@delete');
    });
});

$router->group(['prefix' => 'profile/{profile_id}/attributes'], function () use ($router) {
    // Rotte accessibili pubblicamente
    $router->get('/', 'ProfileAttributeController@index');
    $router->get('/{id}', 'ProfileAttributeController@show');

    // Gruppo di rotte protette
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/create', 'ProfileAttributeController@create');
        $router->put('/update[/{id}]', 'ProfileAttributeController@update');
        $router->delete('/delete[/{id}]', 'ProfileAttributeController@delete');
    });
});
