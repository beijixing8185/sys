<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;

class OrganizationRecord extends Model
{
    /**
     * 增加收支记录
     */
    public static function add($data,$type=1,$money_type=1){
        $record = new OrganizationRecord;
        $record->oid = $data['organization_id'];
        $record->member_id = $data['member_id'];
        $record->sku_id = $data['sku_id'];
        $record->sku_name = $data['sku_name'];
        $record->num = $data['num'];
        $record->msg = $data['msg'];
        $record->commission = $data['commission'];
        $record->type = $type;
        $record->money_type = $money_type;
        $record->site_id = $data['site_id'];
        return $record->save();
    }
}
