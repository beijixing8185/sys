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


$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function($api){
    //注册登录
    $api->group(['namespace' => 'App\Controllers\V1\Auth', 'prefix' => 'auth'], function ($api) {
        $api->post('register','AuthController@register'); //注册
        $api->post('login','AuthController@login'); //登录
        $api->get('logout','AuthController@logout'); //退出登录
    });


    //测试
    $api->group(['namespace' => 'App\Controllers\V1','middleware'=>'jwt.auth'], function ($api) {
        $api->get('test','TestController@test'); //临时测试
    });



});
