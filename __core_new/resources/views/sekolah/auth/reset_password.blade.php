@extends('layouts.single_page')

@section('addTitle') | Lupa Password @endsection

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
            }, 700);
        });
    </script>
@endsection

@section('content')
    <div class="wrapper wrapper-full-page">
        <div class="full-page  section-image" data-color="blue" data-image="{{ asset('assets/img/full-screen-image-2.jpg') }}" ;>
            <div class="content">
                <div class="container">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                        <form class="form" method="post" action="{{ url('/sch/' . $row->siswas->sekolah_id . '/lupa-password/' . $row->id . '/reset') }}" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="card card-login card-hidden">
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('Nomor Induk') }}</label>
                                            <input type="text" placeholder="Nomor Induk" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ $row->siswas->nomor_induk }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Password') }}</label>
                                            <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">

                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ url('/sch/' . $row->siswas->sekolah_id . '/login') }}" style="font-size: small" class="form-text text-success">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-warning btn-wd">Reset</button>
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