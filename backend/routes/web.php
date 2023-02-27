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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('customers',  ['uses' => 'CustomerController@showAllCustomers']);
    $router->get('customers/{id}', ['uses' => 'CustomerController@showOneCustomer']);
    $router->post('customers', ['uses' => 'CustomerController@create']);
    $router->delete('customers/{id}', ['uses' => 'CustomerController@delete']);
    $router->put('customers/{id}', ['uses' => 'CustomerController@update']);
}); 

$router->group(['prefix' => 'auth'], function() use($router) {
    $router->get('users', 'UserController@showAllUser');
    $router->post('register-user', 'UserController@register');
    $router->post('login', 'UserController@login');
    $router->get('me', 'UserController@me');
    $router->get('refresh', 'UserController@refresh');
    $router->post('logout', 'UserController@logout');
});