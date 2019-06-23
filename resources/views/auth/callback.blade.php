<form id="authsteem" action="{{ $cbUrl }}" method="post">
    @foreach ($data as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
    @endforeach
</form>
<script type="text/javascript">
    document.getElementById('authsteem').submit();
</script>