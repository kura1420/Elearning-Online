<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ config('app.name', 'Laravel') }} @yield('addTitle') </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/light-bootstrap-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/css-loader/dist/css-loader.css') }}">
    @yield('addCss')

</head>

<body>
<div class="loader loader-double" id="_loader_"></div>
<div class="wrapper">
    @switch(Auth::user()->type)
        @case('mgt')
            @include('magenta.layout.sidebar')
        @break

        @case('sch')
            @include('sekolah.layout.sidebar')
        @break

        @default
            No include sidebar

    @endswitch

    <div class="main-panel">
        @switch(Auth::user()->type)
            @case('mgt')
                @include('magenta.layout.navbar')
            @break

            @case('sch')
                @include('sekolah.layout.navbar')
            @break

            @default
                No include navbar

        @endswitch

        @yield('content')

        @yield('addModal')

        <footer class="footer">
            <div class="container">
                <nav>
                    <p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#">APC Tim</a>, made with love for a better web
                    </p>
                </nav>
            </div>
        </footer>
    </div>
</div>
</body>
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/light-bootstrap-dashboard.js?v=2.0.1') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/url.js') }}"></script>
@yield('addJs')

</html>