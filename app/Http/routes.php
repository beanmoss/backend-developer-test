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

$rest = function ($path, $controller) use ($app)
{
    $app->get($path, $controller.'@index');
    $app->get($path.'/{id}', $controller.'@show');
    $app->post($path, $controller.'@store');
    $app->put($path.'/{id}', $controller.'@update');
    $app->patch($path.'/{id}', $controller.'@update');
    $app->delete($path.'/{id}', $controller.'@destroy');
};

$rest('/user', 'App\Http\Controllers\UserController');
