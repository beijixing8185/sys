<?php

namespace App\Controllers\V1;

use App\Facades\CheckSign;
use App\Facades\SysApi;
use App\Models\Admin\AdminSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test(){
        dd(app('request')->all());
        dd(request());
        // signature
        //timestamp
        //$arg = ['id'=>1,'timestamp'=>1534736778];

        //dd(CheckSign::checkSign($arg,'006DEA9412481C784F726F782D855CA'));

    }
}
