<?php

namespace App\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(){
        dd(111);
    }
}
