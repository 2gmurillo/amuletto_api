<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

JsonApi::register('default')->routes(function ($api) {
    $api->resource('products')->relationships(function ($api) {
        $api->hasOne('user')->except('replace');
    });
    $api->resource('users')->only('index', 'read');
});
