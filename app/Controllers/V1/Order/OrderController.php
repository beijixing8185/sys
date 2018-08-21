<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:39
 */

namespace App\Controllers\V1\Order;


use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * 添加组织者下的会员用户
     * @param Request $request
     */
    public function addOrder(Request $request)
    {
        $param = $request ->all();
        Order::addOrder($param);
    }


    /**
     * 修改订单数据
     * @param Request $request
     */
    public function updateOrder(Request $request)
    {
        $param = $request ->all();


    }
}