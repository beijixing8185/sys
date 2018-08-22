<?php

$api->version('v1',function($api){
    //佣金同步
    $api->group(['namespace' => 'App\Controllers\V1\Order','prefix'=>'order'], function ($api) { //,'middleware'=>'jwt.auth'
        $api->post('syncCommission','CommissionController@addCommission'); //添加佣金
        $api->post('syncFreezeCommission','CommissionController@freezeCommission'); //冻结佣金
        $api->post('syncRebateCommission','CommissionController@rebateCommission'); //佣金返利
    });

});