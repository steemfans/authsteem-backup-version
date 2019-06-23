@extends('layouts.app')

@section('title', 'AuthSteem')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>AuthSteem</h1>
            @if (env('APP_ENV') == 'local')
            <p><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'login', 'test' => 1]) }}">开始</a></p>
            @else
            <p><a href="{{ route('auth', ['app_id' => 'authsteem', 'scope' => 'login']) }}">开始</a></p>
            @endif
            <p><a href="{{ route('home_docs') }}">文档</a></p>
        </div>
    </div>
@endsection
