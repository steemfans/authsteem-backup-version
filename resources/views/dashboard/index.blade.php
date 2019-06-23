@extends('layouts.app')

@section('title', 'AuthSteem应用管理面板')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>应用信息</h1>
        </div>
        <div class="col-xs-6">
            <form method="post" action="">
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
                    <input type="text" class="form-control" id="app_name" name="app_name" value="{{ $app_name }}">
                </div>
                <div class="form-group">
                    <label for="app_icon">应用图标地址 (用于显示在授权页面, 图片URL)</label>
                    <input type="text" class="form-control" id="app_icon" name="app_icon" value="{{ $app_icon }}">
                </div>
                <div class="form-group">
                    <label for="app_desc">应用简介</label>
                    <textarea class="form-control" id="app_desc" name="app_desc">{{ $app_desc }}</textarea>
                </div>
                <div class="form-group">
                    <label for="app_site">网站地址</label>
                    <input type="text" class="form-control" id="app_site" name="app_site" value="{{ $app_site }}">
                </div>
                <div class="form-group">
                    <label for="cb_uri">回调地址</label>
                    <textarea class="form-control" id="cb_uri" name="cb_uri">{{ $cb_uri }}</textarea>
                </div>
                <div class="form-group">
                    <label for="test_cb_uri">回调地址 (测试用)</label>
                    <textarea class="form-control" id="test_cb_uri" name="test_cb_uri">{{ $test_cb_uri }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">更新</button>
            </form>
        </div>
        <div class="col-xs-6">&nbsp;</div>
    </div>
@endsection
