<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 17:07
 */

namespace App\Controllers\V1\Order;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Order\OrderGood;
use Illuminate\Http\Request;

class OrderGoodsController extends Controller
{

    /**
     * 添加子订单信息，@srv队列任务同步数据时时所用
     * @param Request $request
     * @return mixed
     *
     */
    public function addOrderGoods(Request $request)
    {
        $data = $request ->all();
        $orderGoodId = OrderGood::insertGetId($data);
        if(!$orderGoodId) return SysApi::apiResponse(-1,'添加订单失败');
        return SysApi::apiResponse(0,'添加订单成功',$orderGoodId);
    }


    /**
     * 修改订单子表 @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function updateOrderGoods(Request $request)
    {

        $param = $request ->all();
        $rules = ['plat_order_state' => ['required','integer'],'zid' => ['required','integer'],'plat_order_goods_id' => ['required','integer']];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){
            return SysApi::apiResponse(-1,'请求参数错误，请检查');
        }else {
                $data['plat_order_state'] = $param['plat_order_state'];
                $orderGoods = OrderGood::orderGoodsUpdate($param['zid'], $param['plat_order_goods_id'], $data);
                if (!$orderGoods) return SysApi::apiResponse(-1, '修改订单失败');
                return SysApi::apiResponse(0, '修改订单成功');
        }
    }

}