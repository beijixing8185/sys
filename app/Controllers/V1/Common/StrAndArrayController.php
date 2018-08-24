<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/23
 * Time: 10:44
 */

namespace App\Controllers\V1\Common;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;

class StrAndArrayController extends Controller
{

    /**
     * @param $array //为传过来的参数
     * @param $data  //为需要检验的数组
     * @return mixed
     */
    public static function isExistArray($array,$data)
    {
        foreach ($array as $key => $val){
            if (!in_array($key,$data)) {
                return SysApi::apiResponse(104,'业务参数错误，请校验后提交');
            }
        }
    }
}