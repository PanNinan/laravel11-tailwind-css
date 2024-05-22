<?php

namespace App\Http\Controllers;

class IndexController
{
    // 新增队列数据
    public function addQueue()
    {
        $redis = app('redis.connection');
        $redis->rPush('test-queue', '1');
        $redis->rPush('test-queue', '2');
        $redis->rPush('test-queue', '3');
        $redis->rPush('test-queue', '4');
        $redis->rPush('test-queue', '5');
        $redis->rPush('test-queue', '6');
        $redis->rPush('test-queue', '7');
        echo 'success';
    }
}
