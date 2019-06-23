<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        @if (env('APP_ENV', 'local') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137997878-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-137997878-2');
        </script>
        @endif
        @yield('customcss')
    </head>
    <body>
        <div class="container-fluid" style="orverflow-x: hidden;">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4" style="margin-top: 10px;">
                    @if (isset($_GET['test']))
                        <div class="alert alert-warning">
                            正在测试环境中
                        </div>
                    @endif
                    @if (session('status1'))
                        <div class="alert alert-success">
                            {{ session('status1') }}
                        </div>
                    @endif
                    @if (session('status0'))
                        <div class="alert alert-danger">
                            {{ session('status0') }}
                        </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4" style="margin-top: 10px;">
                    @yield('body')
                </div>
            </div>
        </div>
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        @yield('customjs')
    </body>
</html>
