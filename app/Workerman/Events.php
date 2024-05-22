<?php

namespace App\Workerman;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Workerman\Connection\AsyncTcpConnection;

class Events
{
    public static function onWorkerStart($worker): void
    {
        echo 'workman进程启动,进程id ' . $worker->id . PHP_EOL;

        //监听redis队列
        $redis = app('redis.connection');
        while (true) {
            //读取redis队列
            $data = $redis->lPop('test-queue');
            if ($data) {
                //处理业务
                echo '进程id ' . $worker->id . ' 开始处理业务数据' . $data . PHP_EOL;
                //模拟耗时任务
                sleep(rand(1, 5));
                echo '进程id ' . $worker->id . ' 处理业务数据' . $data . ' 完成' . PHP_EOL;
            } else {
                echo '进程id ' . $worker->id . ' 空闲中，休息5秒' . PHP_EOL;
                sleep(5);
            }
        }
    }

    public static function onWorkerStart1($worker): void
    {
        echo 'Workerman进程启动，进程ID: ' . $worker->id . PHP_EOL;

        // 创建Redis异步连接
        $redis_connection = new AsyncTcpConnection('tcp://127.0.0.1:6379');
        $redis_connection->onConnect = static function ($redis_connection) use ($worker) {
            echo 'Redis连接成功' . PHP_EOL;

            // 监听test-queue队列
            $redis_connection->send("SUBSCRIBE test-queue");
        };
        $redis_connection->onMessage = static function ($redis_connection, $data) use ($worker) {
            // 处理业务
            echo '进程ID: ' . $worker->id . ' 开始处理业务数据: ' . $data . PHP_EOL;
            // 模拟耗时任务
            sleep(5);
            echo '进程ID: ' . $worker->id . ' 处理业务数据: ' . $data . ' 完成' . PHP_EOL;
            $message = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            if (!empty($message['type']) && $message['type'] === 'message') {
                // 获取队列数据
                $data = $message['data'];
            }
        };
        // 连接Redis
        $redis_connection->connect();
    }

    public static function onConnect($client_id): void
    {
    }

    public static function onWebSocketConnect($client_id, $data): void
    {
    }

    public static function onMessage($client_id, $message): void
    {
    }

    public static function onClose($client_id): void
    {
    }
}
