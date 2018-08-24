<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrganizationDetail extends Model
{
    /**
     * 更新佣金和销售数量
     */
    public static function updateCommission($id,$site_id,$commission = 0.00,$sale_num = 0,$money = 0.00){
       return OrganizationDetail::where(['oid'=>$id,'site_id'=>$site_id])
            ->update([
                'commission' => DB::raw('commission + '.$commission),
                'sale_num'  => DB::raw('sale_num + '.$sale_num),
                'sale_money'  => DB::raw('sale_money + '.$money),
            ]);
    }
}
