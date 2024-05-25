@extends('app')

@section('content')
    <div class="container">
        <div class="">
            <a href="{{ route('index') }}" class="btn btn-secondary btn-sm">返回</a>
        </div>

        <div class="row mt-3 min-height-200 align-items-center">
            <form action="{{ route('put-setting') }}" method="POST" accept-charset="UTF-8">
                @csrf
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">终端设备状态数据缺失：</label>
                    <div class="col-sm-2">
                        <p >连续数据间隔大于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-1">
                        <p>——</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">终端GSM信号弱：</label>
                    <div class="col-sm-2">
                        <p>信号值小于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器列表数据缺失：</label>
                    <div class="col-sm-2">
                        <p>连续数据间隔大于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器连接状态异常：</label>
                    <div class="col-sm-2">
                        <p>连接状态上报为</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">六轴SD数据缺失：</label>
                    <div class="col-sm-3">
                        <p>工作状态，连续数据间隔</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-3">
                        <p>休眠状态，连续数据间隔</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器设备状态数据缺失：</label>
                    <div class="col-sm-2">
                        <p>连续数据间隔大于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器设备蓝牙连接异常：</label>
                    <div class="col-sm-2">
                        <p>连接数据上报为</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">油位数据缺失：</label>
                    <div class="col-sm-2">
                        <p>连续数据间隔大于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                    <div class="col-sm-2">
                        <p >分钟</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">油位传感器信号异常：</label>
                    <div class="col-sm-2">
                        <p>信号值小于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器三轴数据缺失：</label>
                    <div class="col-sm-2">
                        <p>信号值小于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">传感器三轴数据异常：</label>
                    <div class="col-sm-2">
                        <p>差值大于</p>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">保存</button>
            </form>
        </div>
    </div>
@endsection
