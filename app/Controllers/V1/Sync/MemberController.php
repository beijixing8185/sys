<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:05
 */

namespace App\Controllers\V1\Sync;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MemberController extends Controller
{

    /**
     * 添加组织者下的会员用户  @srv队列任务同步数据时时所用
     * @param Request $request
     */
    public function add(Request $request)
    {
        $param = $request ->all();
        array_pop($param);
        $member = Member::add($param);
        if(!$member) return SysApi::apiResponse(-1,'失败，请稍后重新尝试');
        return SysApi::apiResponse(0,'会员信息添加成功');
    }


    /**
     * 修改会员信息，@srv队列任务同步数据时时所用
     * @param Request $request
     * @return mixed
     */
    public function updateMember(Request $request)
    {
        $data = [];
        $param = $request ->all();
        $rules = [
            'uid' => ['required','integer'],
            'zid' => ['required','integer']
        ];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){
            return SysApi::apiResponse(422,'缺少需要修改的参数');
        }

        if(isset($param['display_name'])){
            $data['display_name'] = $param['display_name'];
        }
        if(isset($param['display_avatar'])){
            $data['display_avatar'] = $param['display_avatar'];
        }
        //数据库操作
        $result = Member::updates($param['zid'],$param['uid'],$data);

        if($result) return SysApi::apiResponse(0,'会员信息修改成功');
        return SysApi::apiResponse(-1,'修改失败，稍后再试');
    }

}