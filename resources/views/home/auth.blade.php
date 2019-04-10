@extends('layouts.auth')

@section('title', 'AuthSteem')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <p>正在申请权限</p>
        </div>
        <div class="col-xs-12">
            <form>
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">密码或私钥</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">确认授权</button>
            </form>
        </div>
    </div>
@endsection
