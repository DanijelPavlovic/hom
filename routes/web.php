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
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('me', 'AuthController@me');

    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('', 'CategoryController@index');
        $router->get('{id}', 'CategoryController@show');
        $router->post('store', 'CategoryController@store');
        $router->put('update/{id}', 'CategoryController@update');
        $router->delete('{id}', 'CategoryController@destroy');
    });

    $router->group(['prefix' => 'expense'], function () use ($router) {
        $router->get('', 'ExpenseController@index');
        $router->get('{id}', 'ExpenseController@show');
        $router->post('store', 'ExpenseController@store');
        $router->put('update/{id}', 'ExpenseController@update');
        $router->delete('{id}', 'ExpenseController@destroy');
    });

    $router->group(['prefix' => 'analytics'], function () use ($router) {
        $router->get('amount-spent', 'AnalyticsController@amountSpent');
    });
});
