<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MemberCommission extends Model
{
    /**
     * 查询单条数据
     */
    public static function getCommissionByMemberId(array $data){
        $data = ['member_id'=>$data['member_id'],'site_id'=>$data['site_id']];
        $result = self::where($data)->first();
        if(!$result){
            $result = self::creat($data);
        }
        return $result;
    }
}
