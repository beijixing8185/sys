<?php

namespace App\Facades;



use Illuminate\Support\Facades\Facade;

class CheckSign extends Facade
{
    /**
     * 返回类的键值
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'checkSign';
    }
}
    