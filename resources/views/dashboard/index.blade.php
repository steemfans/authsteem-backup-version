@extends('layouts.app')

@section('title', 'AuthSteem Dashboard')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>你创建的应用</h1>
            <p><a href="{{ route('dashboard_app_create') }}" class="btn btn-primary">创建应用</a></p>
            <p>暂无应用</p>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-xs-12">
            <h1>你授权的应用</h1>
            <p>暂无应用</p>
        </div>
    </div>-->
@endsection
