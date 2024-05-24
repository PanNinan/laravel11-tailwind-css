@extends('app')
@section('top-js')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
            integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
@endsection
@section('content')
    <form class="row" action="{{ route('index') }}" method="GET" accept-charset="UTF-8">
        <div class="col-lg form-floating mb-3">
            <input type="text" class="form-control" id="machineName" name="machineName" placeholder=""
                   value="{{ request()->get('machineName') }}">
            <label for="machineName">机械名称</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <select class="form-select" id="category" name="category">
                <option {{ !request()->get('category') ?: 'selected' }} value="0">全部</option>
                @foreach($categories as $item)
                    <option
                        value="{{$item->id}}" {{ request()->get('category') == $item->id ? 'selected' : '' }}>{{$item->category_name}}</option>
                @endforeach
            </select>
            <label for="category">机械类型</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <select class="form-select" id="errorType" name="errorType">
                <option {{ !request()->get('errorType') ?: 'selected' }} value="0">全部</option>
                @foreach($ruleMap as $i => $item)
                    <option value="{{$i}}" {{ request()->get('errorType') == $i ? 'selected' : '' }}>{{$item}}</option>
                @endforeach
            </select>
            <label for="errorType">异常数据</label>
        </div>
        <div class="col-lg mb-3 form-floating">
            <input type="text" class="form-control" id="searchDate" name="searchDate" placeholder=""
                   value="{{ request()->get('searchDate') }}">
            <label for="searchDate" class="form-label">查询日期</label>
        </div>
        <div class="col-lg mb-3 d-flex align-items-center">
            <div>
                <button type="submit" class="btn btn-primary btn-sm" id="submit">查询</button>
                <button type="reset" class="btn btn-secondary btn-sm" id="reset">重置</button>
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
                <th scope="row">电量</th>
                <th scope="row">硬件</th>
                <th scope="row">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($records as $i => $record)
                <tr>
                    <td class="align-middle py-3">{{$record->machine?->machine_name}}</td>
                    <td class="align-middle py-3">{{$record->machine_id}}</td>
                    <td class="align-middle py-3">{{$record->category?->category_name}}</td>
                    <td class="align-middle py-3">{{$ruleMap[$record->rule_id] ?? ''}}</td>
                    <td class="align-middle py-3">{{$record->device?->battery_percent ? $record->device?->battery_percent . '%' : '-'}}</td>
                    <td class="align-middle py-3">{{$record->type == 1 ? $record->device?->product?->product_model : $record->sensor?->product?->product_model}}</td>
                    <td class="align-middle py-3">
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm"
                               href="{{ route('detail', ['id' => $record->id]) }}">查看详情</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
{{--        {{ $records->links() }}--}}
        {!! $records->appends(Request::except('page'))->render() !!}
    </div>
    <script>
        $(function () {
            console.log('123')
            $('#reset').on('click', function () {
                var url = window.location.href;
                var urlParts = url.split('?');
                var baseUrl = urlParts[0];
                var params = new URLSearchParams(urlParts[1]);

                // 保留 page 参数
                var pageValue = params.get('page');
                params = new URLSearchParams();
                if (pageValue) {
                    params.set('page', pageValue);
                    baseUrl = baseUrl + '?' + params.toString()
                }

                window.location.href = baseUrl;
            });
        });
    </script>
@endsection


