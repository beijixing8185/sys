<?php

namespace App\Services\Api;

interface srvApiInterface
{
    public function apiResponse($code = 0,  $message = '',$data = '');

    public function getCodeDescription($code);
   
    public function getIp();
   
    public function getUrlParameter($request);
}