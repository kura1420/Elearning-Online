@extends('layouts.app')

@section('titlePage') Instruksi @endsection

@section('addTitle') | Instruksi @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarUjian').addClass('show');
    $('#sidebarUjianHarian').addClass('active');
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
                <h4 class="card-title">Instruksi Sebelum Mengerjakan Soal</h4>
            </div>
            <div class="card-body">
                <p>
                    Anda akan mengerjakan {{ $row->jenis_ujian }} dari pelajaran {{ $row->pelajaran }} dengan judul ujian "{{ $row->soal }}".
                    Total waktu pengerjaan yaitu {{ $row->total_waktu_pengerjaan }} menit, soal baru dapat di kerjakan pada pukul {{ $row->waktu_mulai }} WIB sampai dengan {{ $row->waktu_habis }} WIB.
                    Jika waktu sudah habis maka soal akan tertutup secara otomatis dan nilai anda akan masuk ke sistem. Gunakan waktu semaksimal mungkin dan simpan selalu jawaban anda ketika selesai menjawab soal serta pastikan koneksi internet di laptop atau komputer anda terjaga dengan baik.
                </p>

                <p>
                    Jika anda sudah siap untuk mengerjakan soal ujian tekan <a href="{{ url($url . '/create?h=' . $row->ujian_harian_id . '&s=' . $row->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Kerjakan</a> tapi jika anda belum siap tekan <a href="{{ url($url) }}" class="btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection