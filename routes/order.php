<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){
    //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Order', 'prefix' => 'order'], function ($api) {

        $api->post('addOrder','OrderController@addOrder'); //新增会员同步

        $api->post('updateOrder','OrderController@updateOrder'); //修改会员同步

        $api->get('syncCommission','CommissionController@addCommission'); //添加佣金

    });



    //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\OrderGoods', 'prefix' => 'orderGoods'], function ($api) {

        $api->post('addOrderGoods','OrderGoodsController@addOrderGoods'); //新增会员同步

        $api->post('updateOrderGoods','OrderGoodsController@updateOrderGoods'); //修改会员同步

    });






});