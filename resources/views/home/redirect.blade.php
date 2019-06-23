@extends('layouts.app')

@section('title', 'AuthSteem')

@section('body')
<form id="authsteem" action="{{ $cbUri }}" method="post">
    @foreach ($data as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
    @endforeach
</form>
@endsection

@section('customjs')
<script type="text/javascript">
    $(function(){
        document.getElementById('authsteem').submit();
    });
</script>
@endsection