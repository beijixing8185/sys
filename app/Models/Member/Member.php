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


    public static function updates($zid,$uid,$data)
    {
        return self::where('site_id',$zid)->where('member_id',$uid)->update($data);
    }

}
