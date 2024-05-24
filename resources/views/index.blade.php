@extends('app')
@section('top-js')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
            integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
@endsection
@section('content')
    <form class="row">
        <div class="col-lg form-floating mb-3">
            <input type="text" class="form-control" id="machineName" placeholder="">
            <label for="machineName">机械名称</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <input type="text" class="form-control" id="category" placeholder="">
            <label for="category">机械类型</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <select class="form-select" id="errorType">
                <option selected value="0">全部</option>
                <option value="1">终端设备状态数据缺失</option>
                <option value="2">终端GSM信号值异常</option>
                <option value="3">传感器列表数据缺失</option>
                <option value="4">传感器连接状态异常</option>
                <option value="5">六轴SD数据缺失</option>
                <option value="6">传感器设备状态数据缺失</option>
                <option value="7">传感器蓝牙连接状态异常</option>
                <option value="8">油位数据缺失</option>
                <option value="9">油位传感器信号强度异常</option>
                <option value="10">传感器三轴数据缺失</option>
                <option value="11">传感器三轴数据异常</option>
            </select>
            <label for="errorType">异常数据</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <input type="email" class="form-control" id="searchDate" placeholder="">
            <label for="searchDate" class="form-label">查询日期</label>

            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3 d-flex align-items-center">
            <div>
                <button type="button" class="btn btn-primary btn-sm" id="submit">查询</button>
                <button type="button" class="btn btn-secondary btn-sm" id="reset">重置</button>
            </div>
            <div class="m-lg-2">
                <a href="{{ route('setting') }}" type="button" class="btn btn-info btn-sm" id="config">异常设置</a>
            </div>
        </div>
    </form>
    <div class="table-responsive shadow-sm bg-body rounded mt-3">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="row">机械名称</th>
                    <th scope="row">机械ID</th>
                    <th scope="row">机械类型</th>
                    <th scope="row">异常数据</th>
                    <th scope="row">工作模式</th>
                    <th scope="row">智能终端</th>
                    <th scope="row">操作</th>
                </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td class="align-middle py-3">测试机械1234{{$i}}</td>
                    <td class="align-middle py-3">1103{{$i}}</td>
                    <td class="align-middle py-3">挖掘机</td>
                    <td class="align-middle py-3">传感器链接异常</td>
                    <td class="align-middle py-3">工作模式 数据{{$i}}</td>
                    <td class="align-middle py-3">Z03.S正常</td>
                    <td class="align-middle py-3">
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm" href="{{ route('detail', ['id' => $i]) }}">查看详情</a>
                        </div>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
    <script>
        $(function () {
            console.log('123')
            // $('#datetimepicker1').datetimepicker();
        });
    </script>
@endsection


