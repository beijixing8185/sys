<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18
 * Time: 11:58
 */

namespace App\Controllers\V1\Sync;


use Illuminate\Http\Request;

class CollageController
{

    /**
     * 添加组织者下的拼团订单 @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function addOrder(Request $request)
    {
        //添加主订单
        $param = $request ->all();
        //$collage =
/*        $order = Order::addOrder($param['order']);

        //添加子订单
        foreach ($param['order_goods'] as $val){
            OrderGoods::insert($val);
        }

        if(!$order) return SysApi::apiResponse(-1,'添加订单失败');
        return SysApi::apiResponse(0,'添加订单成功',$order);*/
    }
}