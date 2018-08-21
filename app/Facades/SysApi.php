<?php

namespace App\Facades;



use Illuminate\Support\Facades\Facade;

class SysApi extends Facade
{
    /**
     * 返回类的键值
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sysApi';
    }
}
    