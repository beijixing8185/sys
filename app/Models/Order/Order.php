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

    public static $field = ['id','create_time','sku_name','sku_image','transport_cost','number','transport_time','arrival_time','finish_time','detail_order_sn','member_id'];   //需要查询的字段


    /**
     * 订单列表
     * @param $where
     * @param int $perPage
     * @param null $page
     * @return mixed
     */
    public static function orderList($where,$perPage = 10,$page = null)
    {
        return self::whereRaw('id > 0 '.$where)
            ->orderBy('id','desc')
            ->paginate($perPage,self::$field,'page',$page);
    }



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