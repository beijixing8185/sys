<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;

class OrganizationRelation extends Model
{
    /**
     * 通过id查询当前的上级组织信息
     */
    public static function getInfoById($id){
        return self::whereId($id)->first();
    }
}
