<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:05
 */

namespace App\Controllers\V1\Member;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{

    /**
     * 添加组织者下的会员用户
     * @param Request $request
     */
    public function addMember(Request $request)
    {
        $param = $request ->all();
        $member = Member::add($param);
        if(!$member) return SysApi::apiResponse(-1,'失败，请稍后重新尝试');
        return SysApi::apiResponse(0,'会员信息修改成功');
    }


    public function updateMember(Request $request)
    {
        $param = $request ->all();
        $rules = ['uid' => ['required','integer'],'zid' => ['required','integer']];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){
            return SysApi::apiResponse(-1,'缺少需要修改的参数');
        }
        if(isset($param['nickname'])){
            $data['display_name'] = $param['display_name'];
            Member::updates($param['zid'],$param['uid'],$data);
            return SysApi::apiResponse(0,'会员信息修改成功');
        }
        if(isset($param['display_avatar'])){
            $data['display_avatar'] = $param['display_avatar'];
            Member::updates($param['zid'],$param['uid'],$data);
            return SysApi::apiResponse(0,'会员信息修改成功');
        }
        return SysApi::apiResponse(-1,'传参有误，请确认');

    }
}