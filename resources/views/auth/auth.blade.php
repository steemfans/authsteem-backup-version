@extends('layouts.auth')

@section('title', 'AuthSteem')

@section('body')
    <div class="row">
        <div class="col-xs-12" style="text-align: center;">
            <img style="width: 100px; height: 100px;" src="{{ $app['app_icon'] }}" />
        </div>
        <div class="col-xs-12" style="text-align: center;">
            <h3>{{ $app['app_name'] }}</h3>
        </div>
        @if ($scope == 'posting')
        <div class="col-xs-12" style="text-align: center;">
            <p>正在申请 <span style="color: red;">Posting</span> 授权(该授权会允许平台使用你的账户发帖，点赞，回复等操作)</p>
        </div>
        @endif
        @if ($scope == 'remove_posting')
        <div class="col-xs-12" style="text-align: center;">
            <p>正在解绑 <span style="color: red;">Posting</span> 授权(该授权会允许平台使用你的账户发帖，点赞，回复等操作)</p>
        </div>
        @endif
        @if ($scope == 'login')
        <div class="col-xs-12" style="text-align: center;">
            <p>应用平台正在申请登录</p>
        </div>
        @endif
        <div class="col-xs-12">
            <form method="post" action="">
                @csrf
                <input type="hidden" name="app_id" value="{{ $app_id }}" />
                <input type="hidden" name="scope" value="{{ $scope }}" />
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    @if (in_array($scope, ['posting', 'remove_posting']))
                    <label for="password">Active私钥</label>
                    @endif
                    @if ($scope == 'login')
                    <label for="password">Posting私钥</label>
                    @endif
                    <input type="password" class="form-control" name="passwd">
                </div>
                <div class="form-group">
                    @if ($scope == 'posting')
                    <button type="submit" class="btn btn-primary">确认授权</button>
                    @endif
                    @if ($scope == 'remove_posting')
                    <button type="submit" class="btn btn-primary">确认解绑</button>
                    @endif
                    @if ($scope == 'login')
                    <button type="submit" class="btn btn-primary">登录</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
