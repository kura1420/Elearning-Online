@extends('layouts.app') 

@section('titlePage') Hasil Ujian Harian @endsection 

@section('addTitle') | Hasil Ujian Harian @endsection 

@section('addCss') 

@endsection 

@section('addJs') 
<script src="https://cdn.tiny.cloud/1/8ad32uo2ibgfvsn8a9zxh9vbg5yw2jfpibw0gjiwzvdqata8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$(document).ready(function () {
    $('#sidebarReport').addClass('show');
    $('#sidebarReportHarian').addClass('active');

    tinymce.init({
        selector: '.jawaban',
        height: 300,
        readonly: 1
    });
});
</script>
@endsection 

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" value="{{ $ujianHarian->tahun_ajaran_id }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $ujianHarian->kelas_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran">Pelajaran</label>
                                    <input type="text" name="pelajaran" id="pelajaran" class="form-control" value="{{ $ujianHarian->pelajaran_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran_tipe">Tipe Pelajaran</label>
                                    <input type="text" name="pelajaran_tipe" id="pelajaran_tipe" class="form-control" value="{{ $ujianHarian->pelajaran_tipe_text }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <input type="text" name="soal" id="soal" class="form-control" value="{{ $ujianHarian->soal_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    @php 
                                    $tipe = NULL; 
                                    switch($ujianHarian->tipe) { 
                                        case 'pg': $tipe = 'Pilihan Ganda'; break; 
                                        case 'es': $tipe = 'Essay'; break; 
                                        case 'cu': $tipe = 'Custome'; break; 
                                        default: $tipe = 'No Defined'; 
                                        } 
                                    @endphp
                                    <input type="text" name="tipe" id="tipe" class="form-control" value="{{ $tipe }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tipe_pilihan_ganda">Tipe Pilihan Ganda</label>
                                    <input type="text" name="tipe_pilihan_ganda" id="tipe_pilihan_ganda" class="form-control" value="{{ strtoupper($ujianHarian->tipe_pilihan_ganda) ?? '-' }}" disabled>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control" disabled placeholder="Judul" value="{{ $ujianHarian->judul }}">
                                </div>
                            </div> -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <input type="text" name="waktu_mulai" id="waktu_mulai" class="form-control" disabled data-autoclose="true" placeholder="Waktu Mulai" value="{{ $ujianHarian->waktu_mulai }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_habis">Waktu Habis</label>
                                    <input type="text" name="waktu_habis" id="waktu_habis" class="form-control" disabled data-autoclose="true" placeholder="Waktu Habis" value="{{ $ujianHarian->waktu_habis }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tanggal_ujian">Tanggal</label>
                                    <input type="text" name="tanggal_ujian" id="tanggal_ujian" class="form-control" disabled placeholder="Tanggal" value="{{ $ujianHarian->tanggal_ujian }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="alert_simpan_jawaban">Alert Simpan Jwb</label>
                                    <input type="text" name="alert_simpan_jawaban" id="alert_simpan_jawaban" class="form-control" disabled placeholder="Alert Simpan Jwb" value="{{ $ujianHarian->alert_simpan_jawaban }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tampilkan_nilai">Tampilkan Nilai</label>
                                    <input type="text" name="tampilan_nilai" id="tampilkan_nilai" class="form-control" value="{{ $ujianHarian->tampilkan_nilai }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="batas_kelulusan">Batas Kelulusan</label>
                                    <input type="text" name="batas_kelulusan" id="batas_kelulusan" class="form-control" disabled placeholder="Batas Kelulusan" value="{{ $ujianHarian->batas_kelulusan ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="jenis_ujian">Jenis Ujian</label>
                                    <input type="text" name="jenis_ujian" id="jenis_ujian" class="form-control" value="{{ $ujianHarian->jenis_ujian_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="rumus_penilaian_ujian">Rumus Penilaian</label>
                                    <input type="text" name="rumus_penilaian_ujian" id="rumus_penilaian_ujian" class="form-control" value="{{ $ujianHarian->rumus_penilaian_ujian_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_acak">Pertanyaan Acak</label>
                                    <input type="text" name="pertanyaan_acak" id="pertanyaan_acak" class="form-control" value="{{ $ujianHarian->pertanyaan_acak }}" disabled>
                                </div>
                            </div>
                        </div>

                        <hr>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="nomor_induk">Nomor Induk</label>
                                    <input type="text" name="nomor_induk" id="nomor_induk" class="form-control" value="{{ $ujianHarian->nomor_induk }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="siswa_id">Nama Siswa</label>
                                    <input type="text" name="siswa_id" id="siswa_id" class="form-control" value="{{ $ujianHarian->nama }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal & Waktu Selesai</label>
                                    <input type="text" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $ujianHarian->tanggal_selesai }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="nilai">Nilai</label>
                                    <input type="text" name="nilai" id="nilai" class="form-control" value="{{ $ujianHarian->nilai }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="total_pertanyaan">Total Pertanyaan</label>
                                    <input type="text" name="total_pertanyaan" id="total_pertanyaan" class="form-control" value="{{ $ujianHarian->total_pertanyaan }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="total_benar">Total Benar</label>
                                    <input type="text" name="total_benar" id="total_benar" class="form-control" value="{{ $ujianHarian->total_benar }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="total_salah">Total Salah</label>
                                    <input type="text" name="total_salah" id="total_salah" class="form-control" value="{{ $ujianHarian->total_salah }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_dijawab">Per. Dijawab</label>
                                    <input type="text" name="pertanyaan_dijawab" id="pertanyaan_dijawab" class="form-control" value="{{ $ujianHarian->pertanyaan_dijawab }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_tidak_dijawab">Per. Tdk Dijawab</label>
                                    <input type="text" name="pertanyaan_tidak_dijawab" id="pertanyaan_tidak_dijawab" class="form-control" value="{{ $ujianHarian->pertanyaan_tidak_dijawab }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_dijawab_ragu">Per. Dijawab Ragu</label>
                                    <input type="text" name="pertanyaan_dijawab_ragu" id="pertanyaan_dijawab_ragu" class="form-control" value="{{ $ujianHarian->pertanyaan_dijawab_ragu }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No.</th>
                                    <th>Pertanyaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soalPertanyaans as $soalPertanyaan)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>@php echo $soalPertanyaan->pertanyaan; @endphp</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <textarea name="{{ $soalPertanyaan->id }}" id="{{ $soalPertanyaan->id }}" class="jawaban" disabled>@php echo $soalPertanyaan->essay; @endphp</textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('addModal') 

@endsection