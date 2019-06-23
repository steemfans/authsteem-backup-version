@extends('layouts.app')

@section('title', 'AuthSteem成功执行')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>成功!</h1>
            @foreach($success as $s)
            <div>{{ $s }}</div>
            @endforeach
        </div>
    </div>
@endsection
