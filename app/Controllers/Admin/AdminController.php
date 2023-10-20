<?php

namespace App\Controllers\Admin;
use App\Bootstrap\BaseController;
use App\Redis\Redis;
use RedisException;


class AdminController extends BaseController
{
    public function ping()
    {
        for ($i = 1 ; $i<=1000 ; $i++){
            $this->dashboard();
        }



        $data = [
            'status' => true ,
            'code' => 200 ,
            'message' => 'pond' ,
            'data' => null ,
        ];
        return $this->response->json($data);
    }


    public function dashboard()
    {
        $requestCount = Redis::increment('request_count');

        return $this->response->json([
            'status' => true ,
            'code' => 200 ,
            'data' => [
                'received_request' => $requestCount ,
            ] ,
        ]);
    }
}