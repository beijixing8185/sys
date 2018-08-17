<?php

namespace App\Controllers\V1;

use App\Models\AdminSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(){
        dd(Auth::user());
    }
}
