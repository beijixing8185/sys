<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:59
 */
$api->version('v1',function($api){
    //组织者的会员信息
    $api->group(['namespace' => 'App\Controllers\V1\Member', 'prefix' => 'member'], function ($api) {

        $api->get('memberList','MemberController@memberList'); //会员列表





        $api->post('addMember','MemberController@addMember'); //新增会员同步 @srv队列任务同步数据时时所用

        $api->post('updateMember','MemberController@updateMember'); //修改会员同步 @srv队列任务同步数据时时所用

    });




});