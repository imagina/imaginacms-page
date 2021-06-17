<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'blocks'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'api.ipage.block.create',
    'uses' => 'BlockApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ipage.block.get.items.by',
    'uses' => 'BlockApiController@index',
    //'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ipage.block.get.item',
    'uses' => 'BlockApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ipage.block.update',
    'uses' => 'BlockApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ipage.block.delete',
    'uses' => 'BlockApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
