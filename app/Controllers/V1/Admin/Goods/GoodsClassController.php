<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 15:03
 */

namespace App\Controllers\V1\Admin\Goods;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Goods\GoodsClass;
use Illuminate\Http\Request;

class GoodsClassController extends Controller
{

    /**
     * 商品分类列表
     */
    public function getGoodsClassList(Request $request)
    {
        $param = $request->all();
        $id = isset($param['id']) ? $param['id'] : 0;
        if(!is_numeric($id)) return SysApi::apiResponse(422,'参数校验错误');

        //查询状态
        $where = '';
        if(!empty($param['state'])){
            if(!is_numeric($param['state'])) return SysApi::apiResponse(422,'参数校验错误');
            $where = ' and state = '.$param['state'];
        }
        $result = GoodsClass::getClassList($id,$where);

        if($result->isEmpty()) return SysApi::apiResponse(430,'请求的数据为空');
        return SysApi::apiResponse(0,'数据获取成功',$result);
    }

    /**
     * 添加组织者下的会员用户  @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function test(Request $request)
    {

        Log::info('接收到得数据：1111111');
        return SysApi::apiResponse(0,'会员信息修改1111111');
    }



}