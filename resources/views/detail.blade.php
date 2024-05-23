@extends('app')

@section('content')
    <style>
        .custom-bg-gray {
            background-color: #ececf4; /* 设置背景色为 #ececf4 */
        }
        .custom-bg-white {
            background-color: #ffffff; /* 设置背景色为 #ececf4 */
        }
    </style>
    <div class="container">
        <a href="{{ route('index') }}" class="btn btn-secondary btn-sm">返回</a>
        <div class="row mt-3">
            <div class="row row-cols-4">
                <div class="col">
                    <div class=" custom-bg-gray">机械名称：</div>
                </div>
                <div class="col">
                    <div class=" custom-bg-gray">机械ID：</div>
                </div>
                <div class="col">
                    <div class=" custom-bg-gray">机械类型：</div>
                </div>
                <div class="col">
                    <div class=" custom-bg-gray">工作模式：</div>
                </div>
                <div class="col mt-1">
                    <div class=" custom-bg-gray">智能终端：</div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class=" custom-bg-gray">Custom column padding</div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="custom-bg-gray">Custom column padding</div>
            </div>
            <div class="col">
                <div class=" custom-bg-gray">Custom column padding</div>
            </div>
        </div>

        <div class="row mt-3 align-items-center">

        </div>

        <div class="row mt-3">
            <div class="col pl-2">
                <div class="custom-bg-gray">Custom column padding</div>
            </div>
            <div class="col pl-2">
                <div class="custom-bg-gray">Custom column padding</div>
            </div>
            <div class="col pl-2">
                <div class="custom-bg-gray">Custom column padding</div>
            </div>
            <div class="col pl-2">
                <div class="custom-bg-gray">Custom column padding</div>
            </div>
        </div>
    </div>
@endsection
