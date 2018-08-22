<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:39
 */

namespace App\Controllers\V1\Order;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{

    /**
     * 添加组织者下的会员用户 @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function addOrder(Request $request)
    {
        $param = $request ->all();
        $order = Order::addOrder($param);
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
        $rules = ['plat_order_state' => ['required','integer'],'site_id' => ['required','integer'],'plat_order_id' => ['required','integer']];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){
            return SysApi::apiResponse(-1,'缺少需要修改的参数');
        }else{
            $data['plat_order_state'] = $param['plat_order_state'];
            $result = Order::updateOrderState($param['zid'],$param['plat_order_id'],$data);
            if(!$result) return SysApi::apiResponse(-1,'修改订单状态失败');
            return SysApi::apiResponse(0,'修改订单状态成功',$result);
        }
    }
}