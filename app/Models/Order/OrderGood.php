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

    public $timestamps = false;
    /**
     * 修改主订单状态
     * @param $zid  组织着id
     * @param $site_order_id    组织者订单号id
     * @param $data 修改的数据
     * @return mixed
     */
    public static function orderGoodsUpdate($zid,$site_order_id,$data)
    {
        return self::where('site_id',$zid) ->where('site_order_goods_id',$site_order_id) ->update($data);
    }
}