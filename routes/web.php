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

$router->get('yelp/api/businesses', 'UploadController@businesses');

$router->get('business', 'BussinessController@get');
$router->get('business/{id}', 'BussinessController@getOne');
$router->post('business', 'BussinessController@store');
$router->put('business/{id}', 'BussinessController@update');
$router->delete('business/{id}', 'BussinessController@  ');

$router->get('review/id/{id}', 'ReviewController@getOne');
$router->get('review/uniq/{id}', 'ReviewController@getUniq');
$router->post('review', 'ReviewController@store');
$router->put('review/{id}', 'ReviewController@update');
$router->delete('review/{id}', 'ReviewController@destroy');