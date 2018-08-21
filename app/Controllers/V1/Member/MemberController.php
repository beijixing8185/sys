<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:05
 */

namespace App\Controllers\V1\Member;


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
        Member::add($param);

    }


    public function updateMember(Request $request)
    {
        $param = $request ->all();
        $this ->validate($request,[
            'uid'=>'required|integer',
            'zid'=>'required|integer'
        ]);
        if(isset($param['nickname'])){
            $data['display_name'] = $param['display_name'];
            Member::updates($param['zid'],$param['uid'],$data);
        }
        if(isset($param['display_avatar'])){
            $data['display_avatar'] = $param['display_avatar'];
            Member::updates($param['zid'],$param['uid'],$data);
        }

    }
}