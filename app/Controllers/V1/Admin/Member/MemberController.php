<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:05
 */

namespace App\Controllers\V1\Admin\Member;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{


    /**
     * 查询单条会员信息
     *
     * @param Request $request
     * @return mixed
     */
    public function getMemberFind(Request $request)
    {
        $param = $request->all();
        if(empty($param['id']) || !is_numeric($param['id'])) return SysApi::apiResponse(422,'校验错误，缺少需要的参数');

        $data = Member::getUserForId($param['id']); //数据库操作

        if(!empty($data)) return SysApi::apiResponse(0,'会员信息获取成功',$data);
        return SysApi::apiResponse(430,'没有找到你要的数据');
    }


    /**
     * 会员列表【分页】【条件筛选】【所有】
     */
    public function getMemberList(Request $request)
    {
        $param = $request -> all();
        $rules = [
            'lock_state' => ['integer'],
            'member_name'=>['string'],
            'grade'=>['integer'],
            'num'=>['integer'],
            'page'=>['integer']
        ];
        $validator = app('validator')->make($param, $rules);
        if($validator->fails()){ return SysApi::apiResponse(422,'参数错误或缺少参数，请检查'); } //校验

        //筛选条件
        $where = '';
        if(isset($param['member_name'])){ $where = ' and member_name like "%'.$param['member_name'].'%"'; } //模糊搜索会员名称
        if(isset($param['lock_state'])){ $where = ' and lock_state = '.$param['lock_state']; }  //根据会员状态搜索
        if(isset($param['grade'])){ $where = ' and grade = '.$param['grade']; }  //根据会员等级搜索
        $num = isset($param['num']) ? $param['num'] : 10; //获取多少条
        $page = isset($param['page']) ? $param['page'] : 1;//当前页码
        $member_list = Member::getMemberList($where,$num,$page);

        if($member_list->isNotEmpty()){
            return SysApi::apiResponse(0,'会员列表获取成功',$member_list);
        }
        return SysApi::apiResponse(-1,'会员列表获取失败，稍后再试');
    }


    /**
     * 会员修改
     * @param Request $request
     * @return mixed
     */
     public function saveMember(Request $request)
     {
         $param = $request->all();
         $rules = [
             'lock_state' => ['integer'],
             'id'=>['integer','required'],
             'grade'=>['integer'],
         ];
         $validator = app('validator')->make($param, $rules);
         if($validator->fails()){
             return SysApi::apiResponse(422,'参数错误或缺少参数，请检查');
         }

         $data = Member::updateMember($param['id'],$param);//数据库操作

         //用来校验传过来的参数
         if($data == true) return SysApi::apiResponse(0,'数据更新成功');
         return SysApi::apiResponse(-1,'数据更新失败');
     }


    /**
     * 会员统计查询（）
     * @return mixed
     */
     public function memberCount()
     {
        $data = Member::memberCountTime();
        return SysApi::apiResponse(0,'数据查询成功',$data);
     }


}