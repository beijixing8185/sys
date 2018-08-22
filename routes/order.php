<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){

    //佣金同步
    $api->group(['namespace' => 'App\Controllers\V1\Order','prefix'=>'order'], function ($api) { //,'middleware'=>'jwt.auth'
        $api->post('syncCommission', 'CommissionController@addCommission'); //添加佣金
        $api->post('syncFreezeCommission', 'CommissionController@freezeCommission'); //冻结佣金
        $api->post('syncRebateCommission', 'CommissionController@rebateCommission'); //佣金返利
    });
    //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Order', 'prefix' => 'order'], function ($api) {

        $api->any('addOrder','OrderController@addOrder'); //新增会员同步

        $api->any('updateOrder','OrderController@updateOrder'); //修改会员同步

        $api->get('syncCommission','CommissionController@addCommission'); //添加佣金

    });



    //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Order', 'prefix' => 'orderGoods'], function ($api) {

        $api->post('addOrderGoods','OrderGoodsController@addOrderGoods'); //新增会员同步

        $api->any('updateOrderGoods','OrderGoodsController@updateOrderGoods'); //修改会员同步

    });






});