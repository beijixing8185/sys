<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 16:17
 */
$api->version('v1',function($api){
    //组织者的会员信息
    $api->group(['namespace' => 'App\Controllers\V1\Admin\Goods', 'prefix' => 'goods'], function ($api) {

        $api->get('getGoodsClassList','GoodsClassController@getGoodsClassList');    //获取商品

        $api->post('test','GoodsClassController@test'); //测试
    });




});