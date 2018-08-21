<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:37
 */

namespace App\Models\Order;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public $timestamps = false;
    /**
     * 添加订单
     * @param $data
     * @return mixed
     */
    public static function addOrder($data)
    {
        return self::insertGetId($data);
    }

    /**
     * 修改订单状态
     * 根据组织者id和组织者订单id修改
     */
    public static function updateOrderState($zid,$site_order_id,$data)
    {
        return self::where('site_id',$zid) ->where('site_order_id',$site_order_id) ->update($data);
    }

}