<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){
    //注册登录
    $api->group(['namespace' => 'App\Controllers\V1\Member', 'prefix' => 'member'], function ($api) {

        //$api->post('login','AuthController@login'); //

        $api->post('addMember','MemberController@addMember'); //新增会员同步
    });




});