<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title>Authsteem</title>
    </head>
    <body>
        <form id="authsteem" action="{{ $cbUri }}" method="post">
            @foreach ($data as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
            @endforeach
        </form>
        <script type="text/javascript">
            document.getElementById('authsteem').submit();
        </script>
    </body>
</html>
