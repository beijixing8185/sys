<?php
namespace App\Services;



class CheckSignServices
{
    /* 生成验证签名
     * @author zf
     * @Time 2018年8月20日
     * $param  args 需要参与生成签名的数据（array 格式）
     * @return 返回签名+时间戳数组
    */
    public static function makeSign(array $args)
    {
        if(empty($args)) {
            return false;
        }

        $args['ext_sign'] = config('constants.ext_sign');  //特有固定参数

        ksort($args);  //按数组的键排序

        $sign = '';

        foreach($args as $k => $v) {
            $sign .= $k . '=' . $v;
        }

        $retData['signature'] = strtoupper(md5($sign));  //加密
        $retData['timestamp'] = $args['timestamp'];

        return $retData;
    }

    /* 验证签名
     * @author zf
     * @Time 2018年8月20日
     * $param  args 需要参与生成签名的数据（array 格式）
     * $param  signature 需要去匹配的签名
     * $param  signtype 'yes':验证，'no'：不验证
     * @return true 匹配成功  false 匹配失败
    */
    public static function checkSign(array $args, $signature, $signtype = 'yes')
    {

        if(empty($args) || empty($signature)) {
            return false;
        }

        $args['ext_sign'] = config('constants.ext_sign');  //特有固定参数

        ksort($args);  //按数组的键排序

        $sign = '';

        foreach($args as $k => $v) {
            $sign .= $k . '=' . $v;
        }
        $sign = strtoupper(md5($sign));  //加密
        if($sign == $signature) {
            return true;
        }
        return false;
    }

}