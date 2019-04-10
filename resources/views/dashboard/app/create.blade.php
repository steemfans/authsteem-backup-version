@extends('layouts.app')

@section('title', 'AuthSteem Dashboard -- Create Application')

@section('body')
    <div class="row">
        <div class="col-xs-6">
            <p><a href="{{ route('dashboard_index') }}" class="btn btn-warning">返回</a></p>
            <p>创建新的应用需要3 STEEM.</p>
            <form>
                <div class="form-group">
                    <label for="app_id">应用ID <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="app_id">
                </div>
                <div class="form-group">
                    <label for="app_name">应用名</label>
                    <input type="text" class="form-control" id="app_name" name="app_name">
                </div>
                <div class="form-group">
                    <label for="app_icon">应用图标地址</label>
                    <input type="text" class="form-control" id="app_icon" name="app_icon">
                </div>
                <div class="form-group">
                    <label for="app_description">应用简介</label>
                    <textarea class="form-control" id="app_description" name="app_description"></textarea>
                </div>
                <div class="form-group">
                    <label for="website">网站地址</label>
                    <input type="text" class="form-control" id="website" name="website">
                </div>
                <div class="form-group">
                    <label for="callback_uri">回调地址</label>
                    <textarea class="form-control" id="callback_uri" name="callback_uri"></textarea>
                </div>
                <div class="form-group">
                    <label for="test_callback_uri">回调地址(测试用)</label>
                    <textarea class="form-control" id="test_callback_uri" name="test_callback_uri"></textarea>
                </div>
                <div class="form-group">
                    <label for="password">当前用户的密码或active权限的私钥 <span style="color:red;">*</span></label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">创建</button>
            </form>
        </div>
    </div>
@endsection
