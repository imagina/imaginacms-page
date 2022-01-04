<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('/', [
    'uses' => 'PublicController@homepage',
    'as' => 'homepage',
  'middleware' => [
   // 'universal',
    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
    \Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain::class
  ]
]);
