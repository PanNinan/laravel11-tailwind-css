@extends('app')

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
                <option selected value="0">GPS</option>
                <option value="1">工时</option>
                <option value="2">油位</option>
            </select>
            <label for="errorType">异常数据</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <input type="email" class="form-control" id="searchDate" placeholder="">
            <label for="searchDate" class="form-label">查询日期</label>
        </div>
        <div class="col-lg mb-3 d-flex align-items-center">
            <div>
                <button type="button" class="btn btn-primary btn-sm" id="submit">查询</button>
                <button type="button" class="btn btn-secondary btn-sm" id="reset">重置</button>
            </div>
            <div class="m-lg-2">
                <button type="button" class="btn btn-primary btn-sm" id="config">异常设置</button>
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

@endsection
