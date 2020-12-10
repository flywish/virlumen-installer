<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Support\Facades\Redis;

class RedisController extends ApiBaseController
{
    public function setRedis(){
        $res = Redis::set('name', 'virchow');
        var_dump($res);
    }

    public function getRedis(){
        $res = Redis::get('name');
        var_dump($res);
    }
}
