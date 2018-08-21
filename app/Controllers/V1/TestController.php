<?php

namespace App\Controllers\V1;

use App\Facades\CheckSign;
use App\Facades\SysApi;
use App\Models\AdminSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(){
        // signature
        //timestamp
        $arg = ['id'=>1,'timestamp'=>1534736778];

        dd(CheckSign::checkSign($arg,'006DEA9412481C784F726F782D855CA'));
        dd(Auth::user());
    }
}
