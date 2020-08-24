@extends('layouts.single_page')

@section('addTitle') | Mulai Ujian @endsection

@section('addCss')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/css-loader/dist/css-loader.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/FlipClock/compiled/flipclock.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-steps/jquery.steps.css') }}">
<style>
body {
    -webkit-user-select:none;
    -moz-user-select:-moz-none;
    -ms-user-select:none;
    user-select:none;
}

.your-clock {
    zoom: 0.7;
    -moz-transform: scale(0.7);
    display: inline-block;
    width: auto;
}

.tr_jawaban:hover {
    background-color: #dbd9d9;
}
</style>
@endsection

@section('addJs')
<script src="{{ asset('assets/js/url.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/FlipClock/compiled/flipclock.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-steps/jquery.steps.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/ujian_harian_siswa/create_pg.js') }}"></script>
<script>
$(function () {
    @php
    $listPertanyaan = [];
    foreach ($pertanyaans as $sp) {
        $listPertanyaan[] = $sp->id;
    }
    $jsonListPertanyaan = json_encode($listPertanyaan);
    @endphp

    listPertanyaan = @php echo $jsonListPertanyaan @endphp;

    @if ($pertanyaanRagu)
        $("{{ implode(', ', $pertanyaanRagu) }}").val(1);

        listRagu = [
            @foreach ($pertanyaanRagu as $ragu)
            {
                soal_nomor: $('#no-{{ str_replace("#", "", $ragu) }}').text(),
                soal_pertanyaan_id: '{{ str_replace("#", "", $ragu) }}',
            },
            @endforeach
        ];        
    @endif

    @if ($ujianHarianJawabanSiswa)
        listJawaban = [
            @foreach ($ujianHarianJawabanSiswa as $jawaban)
            {
                pertanyaan: '{{ $jawaban['soal_pertanyaan_id'] }}',
                jawaban_nomor: $('#no-{{ str_replace("#", "", $jawaban['soal_pertanyaan_id']) }}').text(),
                jawaban_urutan: $('#jawaban_{{ $jawaban['soal_pertanyaan_jawaban_id'] }}').parent().next().text(),
                jawaban_tipe: @if ($jawaban['tipe'] == 'ragu') '{{ $jawaban['soal_pertanyaan_id'] }}' @else null @endif,
            },
            @endforeach
        ];        
    @endif    
});
</script>
@endsection

@section('content')
<div class="loader loader-double" id="_loader_"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <a class="navbar-brand" href="#" style="color:black;">Ujian Harian</a>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
        
        </ul>
        <span class="navbar-text" style="color:black;">
            {{ Str::title(Auth::user()->name) }}
        </span>
    </div>
</nav>

<div class="content" style="padding-top:2%;">
    <input type="hidden" name="alert" id="alert" value="{{ $row->alert_simpan_jawaban }}">
    <input type="hidden" name="waktu" id="waktu" value="{{ \Carbon\Carbon::now()->diffInMinutes($row->waktu_habis) }}">
    <input type="hidden" name="ujian_harian" id="ujian_harian" value="{{ $row->ujian_harian_id }}">
    <input type="hidden" name="ujian_harian_siswa" id="ujian_harian_siswa" value="{{ $row->id }}">
    <input type="hidden" name="soal" id="soal" value="{{ $soal->id }}">

    <div class="container">
        <div style="text-align: center;">
            <div class="your-clock" id="timer">Timer</div>
        </div>

        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm" id="btnInstruksi">
                    <i class="fa fa-file"></i> Instruksi
                </button>

                <button type="button" class="btn btn-primary btn-sm" id="btnShowAnswer">
                    <i class="fa fa-list-ol"></i> Lihat Soal Terjawab
                </button>

                <button type="button" class="btn btn-primary btn-sm" id="btnSaveAnswer">
                    <i class="fa fa-save"></i> Simpan Jawaban
                </button>

                <button type="button" class="btn btn-primary btn-sm" id="btnFastFinish">
                    <i class="fa fa-flag"></i> Selesaikan Soal
                </button>
            </div>
            <div class="card-body">
                <div id="wizards">
                    @foreach ($pertanyaans as $pertanyaan)
                    <h3>{{ $pertanyaan->id }}</h3>
                    <section>
                        <table border="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No.</th>
                                    <th scope="col">Pertanyaan</th>
                                    <th style="width:10%;">Ragu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" id="no-{{ $pertanyaan->id }}">{{ $loop->iteration }}.</th>
                                    <td>@php echo $pertanyaan->pertanyaan; @endphp</td>
                                    <td>
                                        <select name="{{ $loop->iteration }}." id="{{ $pertanyaan->id }}" class="form-control ragu">
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td colspan="2">
                                        @php
                                        $jawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $pertanyaan->id)->orderBy('urutan', 'asc')->get();
                                        @endphp

                                        <table border="0" width="100%">
                                            @foreach ($jawabans as $jawaban)
                                            <tr class="tr_jawaban">
                                                <td width="2%">
                                                    @php
                                                    $checkedAnswer = strlen(array_search($jawaban->id, array_column($ujianHarianJawabanSiswa, 'soal_pertanyaan_jawaban_id'))) > 0 ? 'checked' : '';
                                                    @endphp

                                                    <input type="radio" name="jawaban_{{ $pertanyaan->id }}" id="jawaban_{{ $jawaban->id }}" value="{{ $jawaban->id }}" class="jawaban" {{ $checkedAnswer }}>
                                                </td>
                                                <td width="2%">{{ $jawaban->urutan }}.</td>
                                                <td>@php echo $jawaban->jawaban; @endphp</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalInstruksi" tabindex="-1" role="dialog" aria-labelledby="modalInstruksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @php echo $soal->instruksi; @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSoalTerjawab" tabindex="-1" role="dialog" aria-labelledby="modalSoalTerjawabLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body table-full-width table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%;">No.</th>
                            <th style="width:10%;">Jawaban</th>
                            <th>Ragu</th>
                        </tr>
                    </thead>
                    <tbody id="listPertanyaanTerjawab">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection