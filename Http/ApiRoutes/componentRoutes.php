<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'components'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'api.ipage.component.create',
    'uses' => 'ComponentApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ipage.component.get.items.by',
    'uses' => 'ComponentApiController@index',
    //'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ipage.component.get.item',
    'uses' => 'ComponentApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ipage.component.update',
    'uses' => 'ComponentApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ipage.component.delete',
    'uses' => 'ComponentApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
