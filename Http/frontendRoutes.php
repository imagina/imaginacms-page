<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('/', [
    'uses' => 'PublicController@homepage',
    'as' => 'homepage',
    'middleware' => config('asgard.page.config.middleware'),
]);
