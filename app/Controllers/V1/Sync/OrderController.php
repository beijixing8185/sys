<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:39
 */

namespace App\Controllers\V1\Sync;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Log\LogOrderPlat;
use App\Models\Order\Order;
use App\Models\Order\OrderGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{

    /**
     * 添加组织者下的会员用户 @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function addOrder(Request $request)
    {
        //添加主订单
        $param = $request ->all();
        $order = Order::addOrder($param['order']);

        //添加子订单
        foreach ($param['order_goods'] as $val){
            OrderGoods::insert($val);
        }

        if(!$order) return SysApi::apiResponse(-1,'添加订单失败');
        return SysApi::apiResponse(0,'添加订单成功',$order);
    }


    /**
     * 修改订单数据 @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function updateOrder(Request $request)
    {
        $param = $request ->all();
        $rules = [
            'plat_order_state' => ['required','integer'],
            'zid' => ['required','integer'],
            'plat_order_id' => ['required','integer']
        ];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){
            return SysApi::apiResponse(-1,'缺少需要修改的参数');
        }else{
            //此处未使用事务
            $data['plat_order_state'] = $param['plat_order_state'];
            $result = Order::updateOrderState($param['zid'],$param['plat_order_id'],$data);
            if($param['plat_order_state'] == 2){
                OrderGoods::updateOrderGoodsState($param['zid'],$param['plat_order_id'],$param['plat_order_state']);
            }
            $msg = '修改订单状态为'.$param['plat_order_state'];
            LogOrderPlat::logOrderPlat($param['plat_order_id'],0,$msg,$param['plat_order_state'],0,'用户',$param['zid']);

            if(!$result) return SysApi::apiResponse(-1,'修改订单状态失败');
            return SysApi::apiResponse(0,'修改订单状态成功',$result);
        }
    }
}