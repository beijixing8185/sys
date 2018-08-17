<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;


class Member extends Model
{

    /**
     * 添加用户
     * @param $request
     */
    public static function add(array $data){
       return self::insert($data);
    }

}
