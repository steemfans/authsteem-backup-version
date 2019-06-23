@extends('layouts.app')

@section('title', 'AuthSteem')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>AuthSteem</h1>
            <p><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'login']) }}">开始</a></p>
        </div>
    </div>
@endsection
