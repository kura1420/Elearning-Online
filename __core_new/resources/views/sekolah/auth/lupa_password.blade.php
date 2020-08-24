@extends('layouts.single_page')

@section('addTitle') | Lupa Password @endsection

@section('addCss')
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
@endsection

@section('addJs')
    <script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script>
        $(function () {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                $('.card').removeClass('card-hidden');
            }, 700);

            $('.datepicker').datetimepicker({
                format: 'DD-MM-YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="wrapper wrapper-full-page">
        <div class="full-page  section-image" data-color="blue" data-image="{{ asset('assets/img/full-screen-image-2.jpg') }}" ;>
            <div class="content">
                <div class="container">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                        <form class="form" method="post" action="{{ url('/sch/' . $row->id . '/lupa-password') }}" autocomplete="off">
                            @csrf
                            <div class="card card-login card-hidden">
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('Nomor Induk') }}</label>
                                            <input type="text" placeholder="Nomor Induk" class="form-control @error('nomor_induk') is-invalid @enderror" name="nomor_induk" id="nomor_induk" value="{{ old('nomor_induk') }}">
                                            <input type="hidden" name="sekolah" id="sekolah" value="{{ $row->id }}">

                                            @error('nomor_induk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Tanggal Lahir') }}</label>
                                            <input type="text" placeholder="Tanggal Lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">

                                            @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Tipe') }}</label>
                                            <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                                                <option value="">- Pilih -</option>
                                                <option value="gr" {{ old('tipe') == 'gr' ? 'selected' : '' }}>Guru</option>
                                                <option value="ss" {{ old('tipe') == 'ss' ? 'selected' : '' }}>Siswa</option>
                                            </select>

                                            @error('tipe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ url('/sch/' . $row->id . '/login') }}" style="font-size: small" class="form-text text-success">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-warning btn-wd">Check</button>
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