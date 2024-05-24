@extends('app')

@section('content')
    <style>
        .min-height-100 {
            min-height: 100px; /* 设置每一行的最小高度 */
            border: 1px solid #ccc; /* 可视化边界 */
        }

        .min-height-200 {
            min-height: 200px; /* 设置每一行的最小高度 */
            border: 1px solid #ccc; /* 可视化边界 */
        }

        .min-height-300 {
            min-height: 300px; /* 设置每一行的最小高度 */
            border: 1px solid #ccc; /* 可视化边界 */
        }

        .custom-bg-gray {
            background-color: #ececf4; /* 设置背景色为 #ececf4 */
        }

        .custom-bg-white {
            background-color: #ffffff; /* 设置背景色为 #ececf4 */
        }
    </style>
    <div class="container">
        <div class="">
            <a href="{{ route('index') }}" class="btn btn-secondary btn-sm">返回</a>
        </div>

        <div class="row row-cols-4 mt-2 min-height-100 ">
            <div class="col custom-bg-gray">
                <div class="">机械名称：测试机械1234</div>
            </div>
            <div class="col custom-bg-gray">
                <div class="">机械ID：102786</div>
            </div>
            <div class="col custom-bg-gray">
                <div class="">机械类型：挖掘机</div>
            </div>
            <div class="col custom-bg-gray">
                <div class="">工作模式：下发-实时A</div>
                <div class="">当前：实时A</div>
            </div>
            <div class="col mt-1 custom-bg-gray">
                <div class="">智能终端： Z30185001700 Z03.0(正常)</div>
            </div>
        </div>
        <div class="row mt-3 min-height-100">
            <div>
                <p><i class="bi bi-cpu-fill"></i>智能分析</p>
            </div>
            <div>
                <p>该机械今日异常数据包括：设备状态数据缺失</p>
            </div>
            <div>
                <p>数据异常可能原因：1该类型终端硬件异常</p>
            </div>
        </div>

        <div class="row mt-3 min-height-300">
            <div class="col">
                <p><i class="bi bi-bar-chart-line-fill"></i>异常数据趋势</p>
                <div id="chart1" style="width: 600px; height: 400px;"></div>
            </div>
            <div class="col">
                <p><i class="bi bi-pie-chart-fill"></i>异常数据类型分布</p>
                <div id="chart2" style="width: 420px; height: 400px;"></div>
            </div>
        </div>

        <div class="row mt-3 min-height-200 align-items-center">
            <p><i class="bi bi-fan"></i>数据状态</p>
            <div class="col pl-2">
                <div class="">设置状态<i class="bi bi-chevron-right"></i></div>
                <div class="mt-2">今日异常：2次</div>
                <div class="mt-2">近3天异常：5次</div>
            </div>
            <div class="col pl-2">
                <div class="">传感器列表<i class="bi bi-chevron-right"></i></div>
                <div class="mt-2">今日异常：2次</div>
                <div class="mt-2">近3天异常：5次</div>
            </div>
            <div class="col pl-2">
                <div class="">模式参数<i class="bi bi-chevron-right"></i></div>
                <div class="mt-2">今日异常：2次</div>
                <div class="mt-2">近3天异常：5次</div>
            </div>
            <div class="col pl-2">
                <div class="">GPS<i class="bi bi-chevron-right"></i></div>
                <div class="mt-2">今日异常：2次</div>
                <div class="mt-2">近3天异常：5次</div>
            </div>
            <div class="col pl-2">
                <div class="">心跳<i class="bi bi-chevron-right"></i></div>
                <div class="mt-2">今日异常：2次</div>
                <div class="mt-2">近3天异常：5次</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myChart = echarts.init(document.getElementById('chart1'));
            option = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        }
                    }
                },
                toolbox: {
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {
                    data: ['Evaporation', 'Temperature']
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        axisPointer: {
                            type: 'shadow'
                        }
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: 'Precipitation',
                        min: 0,
                        max: 250,
                        interval: 50,
                        axisLabel: {
                            formatter: '{value} ml'
                        }
                    },
                    {
                        type: 'value',
                        name: 'Temperature',
                        min: 0,
                        max: 25,
                        interval: 5,
                        axisLabel: {
                            formatter: '{value} °C'
                        }
                    }
                ],
                series: [
                    {
                        name: 'Evaporation',
                        type: 'bar',
                        tooltip: {
                            valueFormatter: function (value) {
                                return value + ' ml';
                            }
                        },
                        data: [
                            2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3
                        ]
                    },
                    {
                        name: 'Temperature',
                        type: 'line',
                        yAxisIndex: 1,
                        tooltip: {
                            valueFormatter: function (value) {
                                return value + ' °C';
                            }
                        },
                        data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
                    }
                ]
            };
            myChart.setOption(option);
        });

        document.addEventListener('DOMContentLoaded', function () {
            var myChart = echarts.init(document.getElementById('chart2'));
            option = {
                title: {
                    text: 'Referer of a Website',
                    subtext: 'Fake Data',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left'
                },
                series: [
                    {
                        name: 'Access From',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            {value: 1048, name: 'Search Engine'},
                            {value: 735, name: 'Direct'},
                            {value: 580, name: 'Email'},
                            {value: 484, name: 'Union Ads'},
                            {value: 300, name: 'Video Ads'}
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            myChart.setOption(option);
        });
    </script>
@endsection
