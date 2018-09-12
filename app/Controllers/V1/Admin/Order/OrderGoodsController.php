<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 15:34
 */

namespace App\Controllers\V1\Admin\Order;


use App\Http\Controllers\Controller;
use App\Models\Admin\AdminSite;
use App\Models\Order\OrderGoods;
use Illuminate\Http\Request;
use App\Facades\SysApi;

class OrderGoodsController extends Controller
{


    /**
     * 子订单列表    @分页     @条件筛选
     * @param Request $request
     * @return mixed
     */
    public function orderGoodsList(Request $request)
    {
        $param = $request -> all();
        $rules = [
            'detail_order_sn' => ['integer'],
            'member_id' => ['integer'],
            'goods_state' => ['integer'],
            'plat_order_state' => ['integer'],
            'num' => ['integer'],
            'page' => ['integer']
        ];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){ return SysApi::apiResponse(422,'参数错误或缺少参数，请检查'); } //校验

        $where = '';//筛选条件
        //根据订单状态搜索
        if(isset($param['plat_order_state'])) {
            $where = ' and plat_order_state = ' . $param['plat_order_state'];
        }
        //根据订单的商品状态
        if(isset($param['goods_state'])){
            $where = ' and goods_state = '.$param['goods_state'];
        }
        //根据订单编号搜索
        if(isset($param['detail_order_sn'])){
            $where = ' and detail_order_sn = '.$param['detail_order_sn'];
        }
        //根据会员id搜索
        if(isset($param['member_id'])){
            $where = ' and member_id = '.$param['member_id'];
        }

        $num = isset($param['num']) ? $param['num'] : 15; //获取多少条
        $page = isset($param['page']) ? $param['page'] : 1;//当前页码
        $order_list = OrderGoods::orderList($where,$num,$page);

        if($order_list->isNotEmpty()){
            $data = $order_list ->toArray();
            foreach ($data['data'] as &$value){
                $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']); //转时间戳
            }
            return SysApi::apiResponse(0,'订单列表获取成功',$data);
        }
        return SysApi::apiResponse(-1,'订单列表数据错误，稍后尝试');
    }


    /**
     * 订单详情
     * @param Request $request
     * @return mixed
     */
    public function getOrderGoodsDetail(Request $request)
    {
        $param = $request -> all();
        if(empty($param['id']) || !is_numeric($param['id'])) return SysApi::apiResponse(422,'参数校验错误');

        $result = OrderGoods::orderDetailInfo($param['id']);
        if(empty($result)) return SysApi::apiResponse(430,'订单数据为空');
        return SysApi::apiResponse(0,'订单列表获取成功',$result);
    }


    /**
     * 订单数据修改
     * @param Request $request
     * @return mixed
     */
    public function saveOrderGoods(Request $request)
    {
        $param = $request -> all();
        $rules = [
            'id'                => ['integer','required'],
            'goods_state'       => ['integer'],
            'plat_order_state'  => ['integer'],
        ];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){ return SysApi::apiResponse(422,'参数错误或缺少参数，请检查'); } //校验

        $result = OrderGoods::saveOrderGoods($param['id'],$param);
        if($result == true) return SysApi::apiResponse(0,'数据更新成功');
        return SysApi::apiResponse(-1,'数据更新失败');
    }


    /**
     * 查询订单统计@【按照订单状态】
     * @return mixed
     */
    public function getOrderGoodsNumber()
    {
        $data = OrderGoods::getNumber();
        return SysApi::apiResponse(0,'数据查询成功',$data);
    }

}