<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 17:07
 */

namespace App\Controllers\V1\Order;


use App\Http\Controllers\Controller;
use App\Models\Order\OrderGood;
use Illuminate\Http\Request;

class OrderGoodsController extends Controller
{

    public function addOrderGoods(Request $request)
    {
        $data = $request ->all();
        $orderGoodId = OrderGood::insertGetId($data);
        //if(!$orderGoodId) return
    }


    /**
     * 修改订单子表
     * @param Request $request
     */
    public function updateOrderGoods(Request $request)
    {

        $param = $request ->all();
        if($param['plat_order_state']){
            $data['plat_order_state'] = $param['plat_order_state'];
            OrderGood::orderUpdate($param['zid'],$param['id'],$data);
        }
    }

}