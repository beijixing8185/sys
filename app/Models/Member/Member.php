<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;
use App\Controllers\V1\Common\StrAndArrayController;
use Carbon\Carbon;

class Member extends Model
{

    public $timestamps = false;
    public static $field_validate = ['lock_state','id','grade'];
    public static $field = ['id','member_name','nick_name','birthday','avatar','display_name','display_avatar','sex','email','login_num','login_ip','old_login_ip','grade','lock_state','scores','available_commissions','organization_id','freeze_commissions','created_at'];   //需要查询的字段

    /**
     * 添加用户 ###同步队列任务所用###
     * @param $request
     */
    public static function add(array $data){
       return self::insertGetId($data);
    }


    /**
     * 修改用户，###同步队列任务所用###
     * @param $zid //组织者id
     * @param $uid //用户id
     * @param $data//要修改的数据
     * @return mixed
     */
    public static function updates($zid,$uid,$data)
    {
        return self::where('site_id',$zid)->where('member_id',$uid)->update($data);
    }

    /**
     * 查询组织者会员
     * @param array $field
     * @return mixed
     */
    public static function getMemberList($where,$perPage = 10,$page = null)
    {
        return self::whereRaw('id > 0 '.$where)
            ->orderBy('id','desc')
            ->paginate($perPage,self::$field,'page',$page);
    }


    /**
     * 修改会员信息
     * @param $id
     * @param $data
     * @return mixed
     */
    public static function updateMember($id, $data)
    {
        $state =  StrAndArrayController::isExistArray($data,self::$field_validate);
        if($state == true){
            return self::where('id', $id)->update($data);
        }
        return false;
    }

    /**
     * 查询单个用户信息
     */
    public static function getUserForId($id){
        return Self::select(self::$field)->whereId($id)->first();
    }

    /**
     * 统计数据查询
     * @return array
     */
    public static function memberCountTime()
    {
        $data = [];

        #今天数据
        $data['customer_today'] = self::whereDate('created_at', Carbon::today())->count();

        #昨天数据
        $data['customer_yesterday'] = self::whereDate('created_at', Carbon::yesterday())->count();

        // 本月数据
        $data['customer_this_month'] = self::whereMonth('created_at', Carbon::now()->month)->count();

        // 上月数据
        $data['customer_last_month'] = self::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        // 本年数据
        $data['customer_this_year'] = self::whereYear('created_at', Carbon::now()->year)->count();

        // 已封用户数据
        $data['count_state'] = self::whereRaw('lock_state !=0')->count();

        // 全部数据
        $data['count_all'] = self::count();

        return $data;
    }

}
