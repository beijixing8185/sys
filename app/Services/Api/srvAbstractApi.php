<?php

namespace App\Services\Api;

abstract class srvAbstractApi implements srvApiInterface
{
    /**
     *
     * @param int $code
     * @param null $data
     * @param string $message
     * @return mixed
     */
    abstract public function apiResponse($code = 0,  $message = '',$data = '');

    /**
     * 获取返回状态码描述信息
     * @param $code
     * @return mixed|string
     */
    public function getCodeDescription($code)
    {
        $codes = array(
            // 常规代码
            $code => config('errcode.' . $code),
        );
        $result = (isset($codes[$code])) ? $codes[$code] : '未知的执行状态代码';
        return $result;
    }

    /**
     * 获取用户Ip 地址
     * @return  mixed
     */
    public function getIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');

        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * 获取上个路由中的参数
     *  例如 http://shuo.ittun.com/ynmo/public/?a=1  获取到：1
     * @param $request
     * @return string
     */
    public function getUrlParameter($request)
    {
        $url = $request->getRequestUri();
        $str = strrchr($url, '=');
        $str = substr($str, 1);
        return $str;
    }

    /**
     * 发送短信
     * @param $mobile (发送的手机号)
     * @param $message (发送的信息内容)
     * @return bool     (是否成功发送)
     */
    public function sendMessage($mobile, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, config('ynmo.api_key'));
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile, 'message' => $message));
        $res = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($res->error == 0) {
            return true;
        }
        return false;
    }

}