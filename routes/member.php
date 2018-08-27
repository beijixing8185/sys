<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){
    //组织者的会员信息
    $api->group(['namespace' => 'App\Controllers\V1\Admin\Member', 'prefix' => 'member'], function ($api) {

        $api->get('getMemberFind','MemberController@getMemberFind'); //单个会员信息

        $api->get('getMemberList','MemberController@getMemberList'); //会员列表

        $api->post('saveMember','MemberController@saveMember'); //会员修改

        $api->get('memberCount','MemberController@memberCount'); //会员统计查询（日，月，年）


    });




});