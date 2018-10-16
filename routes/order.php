<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){

    //订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Admin\Order', 'prefix' => 'order'], function ($api) {

        $api->get('getOrderList','OrderController@orderList'); //主订单列表查询



    });


    //订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Admin\Order', 'prefix' => 'order'], function ($api) {

        $api->get('getOrderGoodsList','OrderGoodsController@orderGoodsList'); //子订单列表查询

        $api->get('getOrderGoodsDetail','OrderGoodsController@getOrderGoodsDetail'); //子订单详情查询

        $api->post('saveOrderGoods','OrderGoodsController@saveOrderGoods'); //子订单修改

        $api->get('getOrderGoodsNumber','OrderGoodsController@getOrderGoodsNumber'); //订单状态数量统计

    });

});