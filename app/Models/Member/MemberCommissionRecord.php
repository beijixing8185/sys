<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MemberCommissionRecord extends Model
{
    /**
     * 添加记录
     */
    public static function add($params){
        $record = new MemberCommissionRecord();
        $record->member_id = $params['member_id'];
        $record->member_buy_id = $params['member_buy_id'];
        $record->member_buy_name = $params['member_buy_name'];
        $record->sku_id = $params['sku_id'];
        $record->sku_name = $params['sku_name'];
        $record->commission = $params['commission'];
        $record->type = $params['type'];
        $record->resource = $params['resource'];
        $record->status = $params['status'];
        $record->site_id = $params['site_id'];

        return $record->save();
    }
}
