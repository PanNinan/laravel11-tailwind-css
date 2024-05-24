@extends('app')
@section('top-js')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
            integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
@endsection
@section('top-css')
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
@endsection
@section('content')
    <div class="container">
        <div class="">
            <a href="{{ route('index') }}" class="btn btn-secondary btn-sm">返回</a>
        </div>

        <div class="row row-cols-4 mt-2 min-height-100 custom-bg-gray">
            <div class="col pt-3 custom-bg-gray">
                <div class="">机械名称：{{ $record->machine?->machine_name }}</div>
            </div>
            <div class="col pt-3 custom-bg-gray">
                <div class="">机械ID：{{ $record->machine_id }}</div>
            </div>
            <div class="col pt-3 custom-bg-gray">
                <div class="">机械类型：{{ $record->category?->category_name }}</div>
            </div>
            <div class="col pt-3 custom-bg-gray">
                <div class="">电量：{{ $record->type == 1 ? $record->device?->battery_percent . '%' : '-' }}</div>
            </div>
            <div class="col-6 mt-1 pt-1 pb-2 custom-bg-gray">
                @if($record->type == 1)
                    <div class="">智能终端： {{ $record->device?->sn }} {{ $record->device?->product?->product_model }}
                        (正常)
                    </div>
                @else
                    <div class="">传感器： {{ $record->sensor?->sn }} {{ $record->sensor?->product?->product_model }}
                        (正常)
                    </div>
                @endif
            </div>
        </div>

        <div class="row mt-3 min-height-100 custom-bg-gray">
            <div class="pt-3">
                <p><i class="bi bi-cpu-fill"></i>智能分析</p>
            </div>
            {{--            todo --}}
            <div>
                <p>该机械今日异常数据包括：{{$ruleNames}}</p>
            </div>
            <div>
                <p>数据异常可能原因：1该类型终端硬件异常....</p>
            </div>
        </div>

        <div class="row mt-3 min-height-300 custom-bg-gray">
            <div class="col pt-3">
                <p><i class="bi bi-bar-chart-line-fill"></i>异常数据趋势</p>
                <div id="chart1" style="width: 600px; height: 400px;"></div>
            </div>
            <div class="col pt-3">
                <p><i class="bi bi-pie-chart-fill"></i>异常数据类型分布</p>
                <div id="chart2" style="width: 420px; height: 400px;"></div>
            </div>
        </div>

        <div class="row mt-3 min-height-200 align-items-center justify-content-between custom-bg-gray">
            <p><i class="bi bi-fan"></i>数据状态</p>
            @foreach($dataStatistics as $item)
                <div class="col-md-3 m-lg-2 custom-bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ $item['name'] }}</div>
                        <div>
                            <a class="btn btn-link" href="#" role="button" data-bs-toggle="modal"
                               data-bs-target="#staticBackdrop"><i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="mt-2">今日异常：{{$item['today']??0}}次</div>
                    <div class="mt-2">近3天异常：{{$item['three_day']??0}}次</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-xl" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">心跳</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body shadow-sm">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                            <th scope="col">异常数据类型</th>
                            <th scope="col">开始时间</th>
                            <th scope="col">结束时间</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <th scope="row">设备状态数据缺失</th>
                                <td>2024-05-24 11:11:11</td>
                                <td>2024-05-24 18:59:59</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            jQuery(document).ready(function () {

            });
            const myChart1 = echarts.init(document.getElementById('chart1'));
            const xDate = {!! json_encode($xDate) !!};
            const y1 = {!! json_encode($y1) !!};
            const y2 = {!! json_encode($y2) !!};
            const y3 = {!! json_encode($y3) !!};
            let option = {
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
                        dataView: {show: false, readOnly: false},
                        magicType: {show: false, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: false}
                    }
                },
                legend: {
                    data: ['每日异常次数', '同型号终端平均值', '同区域终端平均值']
                },
                xAxis: [
                    {
                        type: 'category',
                        data: xDate,
                        axisPointer: {
                            type: 'shadow'
                        }
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '每日异常次数',
                        min: 0,
                        max: Math.max(...y1) + 10,
                        // interval: 50,
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    {
                        type: 'value',
                        name: '同型号终端平均值',
                        min: 0,
                        max: Math.max(...y2) + 10,
                        interval: 5,
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    {
                        type: 'value',
                        name: '同区域终端平均值',
                        min: 0,
                        max: Math.max(...y3) + 10,
                        interval: 5,
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                ],
                series: [
                    {
                        name: '每日异常次数',
                        type: 'bar',
                        tooltip: {
                            valueFormatter: function (value) {
                                return value;
                            }
                        },
                        data: y1
                    },
                    {
                        name: '同型号终端平均值',
                        type: 'line',
                        yAxisIndex: 1,
                        tooltip: {
                            valueFormatter: function (value) {
                                return value;
                            }
                        },
                        data: y2
                    },
                    {
                        name: '同区域终端平均值',
                        type: 'line',
                        yAxisIndex: 1,
                        tooltip: {
                            valueFormatter: function (value) {
                                return value;
                            }
                        },
                        data: y3
                    }
                ]
            };
            myChart1.setOption(option);

            const myChart2 = echarts.init(document.getElementById('chart2'));
            const pieCounts = {!! json_encode($pieCounts) !!};
            option = {
                title: {
                    text: '',
                    subtext: '',
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
                        name: '',
                        type: 'pie',
                        radius: '50%',
                        data: pieCounts,
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
            myChart2.setOption(option);
        });
    </script>
@endsection
