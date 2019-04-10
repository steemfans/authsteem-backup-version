@extends('layouts.app')

@section('title', 'AuthSteem 出错了!')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <h1>出错了!</h1>
            @foreach($errors as $e)
            <div>{{ $e }}</div>
            @endforeach
        </div>
    </div>
@endsection
