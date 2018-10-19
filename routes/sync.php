<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 16:17
 */
$api->version('v1',function($api){
    //组织者的会员信息
    $api->group(['namespace' => 'App\Controllers\V1\Sync', 'prefix' => 'member'], function ($api) {

        $api->post('syncAddMember','MemberController@add'); //新增会员同步 @srv队列任务同步数据时时所用

        $api->post('syncUpdateMember','MemberController@updateMember'); //修改会员同步 @srv队列任务同步数据时时所用



    });

    //佣金同步      as     //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Sync','prefix'=>'order'], function ($api) { //,'middleware'=>'jwt.auth'

        $api->post('syncCommission', 'CommissionController@addCommission'); //添加佣金

        $api->post('syncFreezeCommission', 'CommissionController@freezeCommission'); //冻结佣金

        $api->post('syncRebateCommission', 'CommissionController@rebateCommission'); //佣金返利

        $api->post('syncAddOrder','OrderController@addOrder'); //新增会员同步

        $api->post('syncUpdateOrder','OrderController@updateOrder'); //修改会员同步
    });

    //组织者的订单信息
    $api->group(['namespace' => 'App\Controllers\V1\Sync', 'prefix' => 'orderGoods'], function ($api) {

        $api->post('syncAddOrderGoods','OrderGoodsController@addOrderGoods'); //新增会员同步

        $api->post('syncUpdateOrderGoods','OrderGoodsController@updateOrderGoods'); //修改会员同步

    });



});
