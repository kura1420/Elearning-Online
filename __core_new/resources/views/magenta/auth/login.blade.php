@extends('layouts.single_page')

@section('addTitle') | Login @endsection

@section('addCss')
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
@endsection

@section('addJs')
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script>
        $(function () {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endsection

@section('content')
    <div class="wrapper wrapper-full-page">
        <div class="full-page  section-image" data-color="blue" data-image="{{ asset('assets/img/full-screen-image-2.jpg') }}" ;>
            <div class="content">
                <div class="container">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                        <form class="form" method="post" action="{{ url('/mgt/login') }}" autocomplete="off">
                            @csrf
                            <div class="card card-login card-hidden">
                                <div class="card-header ">
                                    <h3 class="header text-center">Magenta Login</h3>
                                </div>
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('Username') }}</label>
                                            <input type="text" placeholder="Username" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}">

                                            @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            @if(Session::has('wrong_username_password'))
                                                <small class="form-text text-danger">{{ Session::get('wrong_username_password') }}</small>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Password') }}</label>
                                            <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">

                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <a href="#" style="font-size: small" class="form-text text-primary">Lupa Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-warning btn-wd">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                    </p>
                </nav>
            </div>
        </footer>
    </div>
@endsection