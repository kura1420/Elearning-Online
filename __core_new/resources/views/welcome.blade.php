@extends('layouts.single_page')

@section('addTitle') | Selamat Datang @endsection

@section('addCss')
<link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
@endsection

@section('addJs')
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script>
$(function () {
    demo.checkFullPageBackgroundImage();
});
</script>
@endsection

@section('content')
<div class="wrapper wrapper-full-page">
    <div class="full-page  section-image" data-color="blue" data-image="{{ asset('assets/img/full-screen-image-2.jpg') }}" ;>
        <div class="content">
            <div class="container">
            
            <div class="row">
                @foreach ($rows as $row)
                <div class="col-md-2" style="padding-right:1%">
                    <a href="{{ url('sch/' . $row->id . '/login') }}">
                        <div class="card h-100">
                            @php
                            $logo = isset($row->logo) ? 'uploads/sekolah/logo/' . $row->logo : 'assets/img/nologo.jpg';
                            @endphp
                            <img src="{{ asset($logo) }}" class="card-img-top" style="width:100%;height:150px;">
                            <div class="card-body">
                                <h5 class="card-title" align="center">{{ strtoupper($row->pendidikan) . ' ' . $row->nama }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
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
                    <a href="#">APC Tim</a>, made with love for a better web
                </p>
            </nav>
        </div>
    </footer>
</div>
@endsection