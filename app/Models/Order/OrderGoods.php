<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 17:08
 */

namespace App\Models\Order;


use App\Controllers\V1\Common\StrAndArrayController;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{

    public $timestamps = false;
    protected $table = "order_goods";

    public static $field = ['id','create_time','sku_name','sku_image','transport_cost','number','transport_time','arrival_time','finish_time','detail_order_sn','member_id'];   //需要查询的字段

    public static $field_validate = ['goods_state','plat_order_state','id'];//修改需要验证的字段


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
     * 查询订单详情
     * @param $id
     * @return mixed
     */
    public static function orderDetailInfo($id)
    {
        return self::find($id);
    }


    /**
     * 订单数据修改
     * @param $id
     * @param $data
     * @return bool
     */
    public static function saveOrderGoods($id,$data)
    {
        $state =  StrAndArrayController::isExistArray($data,self::$field_validate);
        if($state == true){
            return self::where('id', $id)->update($data);
        }
        return false;
    }


    /**
     * 订单统计@【状态值】
     * @return array
     */
    public static function getNumber()
    {
        $data = [];

        $data['is_payment'] = self::where('plat_order_state', 1)->count();      //待付款

        $data['already'] = self::where('plat_order_state', 2)->count();         //已付款

        $data['already_shipped'] = self::where('plat_order_state', 3)->count(); //已收货

        $data['off_success'] = self::whereIn('plat_order_state', [4,9])->count();//已收货，已完成

        return $data;
    }


    /**
     * 修改主订单状态@队列任务所用
     * @param $zid  //组织着id
     * @param $site_order_id    //组织者订单号id
     * @param $data //修改的数据
     * @return mixed
     */
    public static function orderGoodsUpdate($zid,$order_id,$order_state)
    {
        return self::whereId($order_id)->where('site_id',$zid)->update(['plat_order_state'=>$order_state]);
    }

    /**
     * 根据主订单修改子订单状态
     * 根据组织者id修改
     */
    public static function updateOrderGoodsState($zid,$order_id,$order_state)
    {
        return self::where('plat_order_id',$order_id)->where('site_id',$zid)->update(['plat_order_state'=>$order_state]);
    }
}