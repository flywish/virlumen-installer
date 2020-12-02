<?php

$api = app('Dingo\Api\Routing\Router');

$api->version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Api'], function ($api) {
    $api->group(['prefix' => 'example'], function ($api) {
        $api->post('success', 'V1\ExampleController@successExample');
        $api->post('error', 'V1\ExampleController@errorExample');
        $api->post('paginator', 'V1\ExampleController@paginatorExample');
        $api->group(['middleware' => 'api.throttle', 'limit' => 10, 'expires' => 1], function($api){
            $api->post('throttle', 'V1\ExampleController@throttleExample');
        });
    });
});

// 用户登录相关
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1\Auth'], function ($api) {
    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('login', 'AuthController@login');
        $api->group(['middleware' => 'auth'], function($api){
            $api->post('logout', 'AuthController@logout');
            $api->post('refresh', 'AuthController@refresh');
            $api->post('me', 'AuthController@me');
        });
    });
});

// 组件相关
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->group(['prefix' => 'component'], function ($api) {
        $api->get('excel_export', 'ComponentController@exportExcel');
        $api->get('excel_read', 'ComponentController@readExcel');
    });
    $api->post('redis_set', 'RedisController@setRedis');
    $api->post('redis_get', 'RedisController@getRedis');
});
