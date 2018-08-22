<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;


class Member extends Model
{

    public $timestamps = false;
    /**
     * 添加用户
     * @param $request
     */
    public static function add(array $data){
       return self::insertGetId($data);
    }


    /**
     * 修改用户，
     * @param $zid 组织者id
     * @param $uid 用户id
     * @param $data
     * @return mixed
     */
    public static function updates($zid,$uid,$data)
    {
        return self::where('site_id',$zid)->where('member_id',$uid)->update($data);
    }

}
