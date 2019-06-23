@extends('layouts.app')

@section('title', 'AuthSteem应用管理面板')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>应用信息</h1>
            <div><a href="{{ route('home_docs') }}">文档</a> | <a href="{{ route('dashboard_logout') }}">退出</a></div>
        </div>
        <div class="col-xs-6">
            <form method="post" action="{{ route('dashboard_index_save') }}">
                @csrf
                <div class="form-group">
                    <label for="app_id">应用ID</label>
                    <input type="text" class="form-control" id="app_id" value="{{ $username }}" disabled>
                </div>
                <div class="form-group">
                    <label for="secret">AppSecret (应用与Authsteem通信签名使用)</label>
                    <input type="text" disabled class="form-control" id="secret" value="{{ $secret }}">
                </div>
                <div class="form-group">
                    <label for="app_name">应用名 (用于显示在授权页面)</label>
                    <input type="text" class="form-control" id="app_name" name="app_name" value="{{ isset($app_name) ? $app_name : null }}">
                </div>
                <div class="form-group">
                    <label for="app_icon">应用图标地址 (用于显示在授权页面, 图片URL)</label>
                    <input type="text" class="form-control" id="app_icon" name="app_icon" value="{{ isset($app_icon) ? $app_icon : null }}">
                </div>
                <div class="form-group">
                    <label for="app_desc">应用简介</label>
                    <textarea class="form-control" id="app_desc" name="app_desc">{{ isset($app_desc) ? $app_desc : null }}</textarea>
                </div>
                <div class="form-group">
                    <label for="app_site">网站地址</label>
                    <input type="text" class="form-control" id="app_site" name="app_site" value="{{ isset($app_site) ? $app_site : null }}">
                </div>
                <div class="form-group">
                    <label for="cb_uri">回调地址</label>
                    <textarea class="form-control" id="cb_uri" name="cb_uri">{{ isset($cb_uri) ? $cb_uri : null }}</textarea>
                </div>
                <div class="form-group">
                    <label for="test_cb_uri">回调地址 (测试用)</label>
                    <textarea class="form-control" id="test_cb_uri" name="test_cb_uri">{{ isset($test_cb_uri) ? $test_cb_uri : null }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">更新</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @if (env('APP_ENV') == 'local')
                <a class="btn btn-danger pull-right" href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'remove_posting', 'test' => 1]) }}">删除应用</a>
                @else
                <a class="btn btn-danger pull-right" href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'remove_posting']) }}">删除应用</a>
                @endif
            </form>
        </div>
        <div class="col-xs-6">&nbsp;</div>
    </div>
@endsection
