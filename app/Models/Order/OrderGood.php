<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 17:08
 */

namespace App\Models\Order;


use Illuminate\Database\Eloquent\Model;

class OrderGood extends Model
{

    public function orderUpdate($zid,$site_order_id,$data)
    {
        self::where('site_id',$zid) ->where('site_order_id',$site_order_id) ->update($data);
    }
}