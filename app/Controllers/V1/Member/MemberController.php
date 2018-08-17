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
}