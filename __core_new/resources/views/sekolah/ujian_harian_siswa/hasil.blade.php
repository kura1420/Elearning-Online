@extends('layouts.single_page')

@section('addTitle') | Hasil Ujian Harian @endsection

@section('addCss')

@endsection

@section('addJs')

@endsection

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <a class="navbar-brand" href="#" style="color:black;">Hasil Ujian Harian</a>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
        
        </ul>
        <span class="navbar-text" style="color:black;">
            {{ Str::title(Auth::user()->name) }}
        </span>
    </div>
</nav>

<div class="content" style="padding-top:2%;">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="text-align:center;">Hasil Ujian {{ $ujianHarian->judul }}</h4>
            </div>
            <div class="card-body">
                <div style="text-align:center;">
                    @if (isset($row->status))
                        @switch($row->status)
                            @case('1')
                                Selamat Anda lulus ujian dengan nilai <b>{{ $row->nilai }}</b>.
                                @break

                            @case('0')
                                Sayang sekali anda belum lulus pada ujian, nilai anda adalah <b class="text-danger">{{ $row->nilai }}</b>, sedangkan batas nilai kelulusan adalah <b class="text-primary">{{ $ujianHarian->batas_kelulusan }}</b>.
                                @break;

                            @default
                                No Defined
                        @endswitch

                        <br>
                    @else 
                        Pertanyaan dijawab sebanyak: {{ $row->pertanyaan_dijawab }} <br>
                        Pertanyaan dijawab ragu sebanyak: {{ $row->pertanyaan_dijawab_ragu }} <br>
                        Pertanyaan tidak dijawab sebanyak: {{ $row->pertanyaan_tidak_dijawab }} <br>
                    @endif    

                    <a href="{{ url('/sch/ujian-harian-siswa') }}" class="btn btn-sm btn-secondary" style="margin-top:2%;">
                        <i class="fa fa-home"></i> Kembali Ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection