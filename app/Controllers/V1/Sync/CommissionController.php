<?php

namespace App\Controllers\V1\Sync;

use App\Facades\SysApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Member\MemberCommission;
use App\Models\Member\MemberCommissionRecord;

class CommissionController extends Controller
{
    public $commissionRecord;
    public $memberCommission;
    public function __construct(
        MemberCommission $memberCommission,
        MemberCommissionRecord $commissionRecord)
    {
        $this->commissionRecord = $commissionRecord;
        $this->memberCommission = $memberCommission;
    }

    /**
     * 查询以及增加一条佣金记录
     */
    public function getCommission(array $data){
        $commission = $this->memberCommission::getCommissionByMemberId($data);
        return $commission;
    }
    /**
     * 添加佣金
     * @param Request $request
     */
    public function addCommission(Request $request){

        $params = $request->all();
        $commission = $this->getCommission($params);
        DB::beginTransaction();
        try{
            // 减少账户的可用佣金
            $commission->decrement('available_commissions',$params['commission']);
            //MemberCommission::where(['member_id'=>$params['member_id'],'site_id'=>$params['site_id']]);

            //添加佣金记录
            $this->commissionRecord::add($params);
            DB::commit();
            return SysApi::apiResponse();
        }catch(Exception $e){
            DB::rollBack();
            Log::info('佣金记录失败:在CommissionController@addCommission'.'-错误信息:'.$e->getMessage());
            return SysApi::apiResponse(-1,$e->getMessage());
        }


    }

    /**
     * 佣金冻结以及释放
     * @param Request $request
     * @return mixed
     */
    public function freezeCommission(Request $request){

        $params = $request->all();
        $commission = $this->getCommission($params);

        if(isset($params['reduce'])){
            $commission->freeze_commissions = bcsub($commission->freeze_commissions, $params['pay_points_amount'], 2);
        }else{
            $commission->freeze_commissions = bcadd($commission->freeze_commissions, $params['pay_points_amount'], 2);
            $commission->available_commissions = bcsub($commission->available_commissions, $params['pay_points_amount'], 2);
        }

        if($commission->save()) return SysApi::apiResponse();
        else return SysApi::apiResponse(-1,'同步-冻结佣金数据保存失败');

    }

    /**
     * 确认收货后佣金返利
     */
    public function  rebateCommission(Request $request){
        $params = $request->all();
        Log::info('返利获取的数据'.json_encode($params));
        dd(11);
        $commission = $this->getCommission($params);

        DB::beginTransaction();
        try{
            //更新父级佣金
            $commission->earnings = bcadd($commission->earnings,$params['commission'],2);
            $commission->available_commissions = bcadd($commission->available_commissions,$params['commission'],2);
            $commission->orders_number = $commission->orders_number + $params['orders_number'];
            $commission->sale_money = bcadd($commission->sale_money,$params['sale_money'],2);

            //添加佣金记录
            $this->commissionRecord::add($params);

            DB::commit();
            return SysApi::apiResponse();
        }catch(Exception $e){
            DB::rollBack();
            Log::info('佣金记录失败:在CommissionController@addCommission'.'-错误信息:'.$e->getMessage());
            return SysApi::apiResponse(-1,$e->getMessage());
        }
    }
}
