@extends('layouts.app')

@section('title', 'AuthSteem')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>AuthSteem</h1>
            <ul class="menu">
                @if (env('APP_ENV') == 'local')
                <li><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'login', 'test' => 1]) }}">登录</a></li>
                @else
                <li><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'login']) }}">登录</a></li>
                @endif
                @if (env('APP_ENV') == 'local')
                <li><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'posting', 'test' => 1]) }}">注册</a></li>
                @else
                <li><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'posting']) }}">注册</a></li>
                @endif
                <li><a href="{{ route('home_docs') }}">文档</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('customcss')
<style>
.menu { 
    font: 18px verdana, arial, sans-serif;
}
.menu, .menu li {
    list-style: none;
    padding: 0;
    margin: 0;
}
.menu li {
    float: left;
    margin-right: 30px;
}
</style>
@endsection
