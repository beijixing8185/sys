<?php

namespace App\Http\Middleware;


use App\Facades\CheckSign;
use App\Facades\SysApi;
use Closure;

class checkSignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //验证接收到的数据
        $requestData = $request->except('signature');
        $signature = $request->input('signature');

        if (empty($signature)) {
            return SysApi::apiResponse(106,'获取失败-缺少签名');

        }

        $result = CheckSign::checkSign($requestData,$signature);
        if(!$result){
            return SysApi::apiResponse(107);
        }

        return $next($request);
    }
}
