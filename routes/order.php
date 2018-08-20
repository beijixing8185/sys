<?php

$api->version('v1',function($api){
    //佣金同步
    $api->group(['namespace' => 'App\Controllers\V1\Order','prefix'=>'order'], function ($api) { //,'middleware'=>'jwt.auth'
        $api->get('syncCommission','CommissionController@addCommission'); //添加佣金
    });

});