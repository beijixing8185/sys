<?php
namespace App\Services\Api;



class SysApiServices extends srvAbstractApi
{
    /**
     * json响应
     * @return json
     */
    public function apiResponse($code = 0,$message='成功',$data=''){
        return response()->json(['code'=>$code,'message'=>$message,'data'=>$data]);
    }

    /**
     * array响应
     * @return array
     */
    public function apiArray($code = 0,$message='',$data=''){
        return ['code'=>$code,'message'=>$message,'data'=>$data];
    }


}