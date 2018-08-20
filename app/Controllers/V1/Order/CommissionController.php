<?php

namespace App\Controllers\V1\Order;

use App\Facades\SysApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    public function addCommission(Request $request){
        return SysApi::apiResponse();
    }
}
