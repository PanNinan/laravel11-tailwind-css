<?php

namespace App\Enum;

class Rule
{
    public const MAP = [
        1 => '终端设备状态数据缺失',
        2 => '终端GSM信号值异常',
        3 => '传感器列表数据缺失',
        4 => '传感器连接状态异常',
        5 => '六轴SD数据缺失',
        6 => '传感器设备状态数据缺失',
        7 => '传感器蓝牙连接状态异常',
        8 => '油位数据缺失',
        9 => '油位传感器信号强度异常',
        10 => '传感器三轴数据缺失',
        11 => '传感器三轴数据异常',
    ];

    public static function translate($index): string
    {
        return self::MAP[$index] ?? '';
    }
}
