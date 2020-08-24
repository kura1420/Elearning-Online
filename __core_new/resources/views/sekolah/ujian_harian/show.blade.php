@extends('layouts.app')

@section('titlePage') Ujian Harian @endsection

@section('addTitle') | Ujian Harian @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/ujian_harian/show.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-header">
                        <h4 class="card-title">
                                Lihat Data
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" value="{{ $row->tahun_ajaran_id }}" disabled>
                                </div>
                            </div>           
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $row->kelas_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran">Pelajaran</label>
                                    <input type="text" name="pelajaran" id="pelajaran" class="form-control" value="{{ $row->pelajaran_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran_tipe">Tipe Pelajaran</label>
                                    <input type="text" name="pelajaran_tipe" id="pelajaran_tipe" class="form-control" value="{{ $row->pelajaran_tipe_text }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <input type="text" name="soal" id="soal" class="form-control" value="{{ $row->soal_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    @php 
                                    $tipe = NULL;
                                    switch($row->tipe) {
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
                                    <input type="text" name="tipe_pilihan_ganda" id="tipe_pilihan_ganda" class="form-control" value="{{ strtoupper($row->tipe_pilihan_ganda) ?? '-' }}" disabled>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control" disabled placeholder="Judul" value="{{ $row->judul }}">
                                </div>
                            </div> -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <input type="text" name="waktu_mulai" id="waktu_mulai" class="form-control" disabled data-autoclose="true" placeholder="Waktu Mulai" value="{{ $row->waktu_mulai }}">
                                </div>
                            </div>  
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_habis">Waktu Habis</label>
                                    <input type="text" name="waktu_habis" id="waktu_habis" class="form-control" disabled data-autoclose="true" placeholder="Waktu Habis" value="{{ $row->waktu_habis }}">
                                </div>
                            </div>   
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control" disabled placeholder="Tanggal" value="{{ $row->tanggal }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">                      
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="alert_simpan_jawaban">Alert Simpan Jwb</label>
                                    <input type="text" name="alert_simpan_jawaban" id="alert_simpan_jawaban" class="form-control" disabled placeholder="Alert Simpan Jwb" value="{{ $row->alert_simpan_jawaban }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tampilkan_nilai">Tampilkan Nilai</label>
                                    <input type="text" name="tampilan_nilai" id="tampilkan_nilai" class="form-control" value="{{ $row->tampilkan_nilai }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="batas_kelulusan">Batas Kelulusan</label>
                                    <input type="text" name="batas_kelulusan" id="batas_kelulusan" class="form-control" disabled placeholder="Batas Kelulusan" value="{{ $row->batas_kelulusan ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="jenis_ujian">Jenis Ujian</label>
                                    <input type="text" name="jenis_ujian" id="jenis_ujian" class="form-control" value="{{ $row->jenis_ujian_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="rumus_penilaian_ujian">Rumus Penilaian</label>
                                    <input type="text" name="rumus_penilaian_ujian" id="rumus_penilaian_ujian" class="form-control" value="{{ $row->rumus_penilaian_ujian_text }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_acak">Pertanyaan Acak</label>
                                    <input type="text" name="pertanyaan_acak" id="pertanyaan_acak" class="form-control" value="{{ $row->pertanyaan_acak }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline">
                        <div class="fresh-datatables">
                            <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nilai</th>
                                        <th style="width:20%;">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nilai</th>
                                        <th style="width:20%;">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($ujianHarianSiswas as $ujianHarianSiswa)
                                    <tr>
                                        <td>{{ $ujianHarianSiswa->nomor_induk }}</td>
                                        <td>{{ $ujianHarianSiswa->nama }}</td>
                                        <td>{{ $ujianHarianSiswa->nilai ?? '-' }}</td>
                                        <td>
                                            @switch($ujianHarianSiswa->status)
                                                @case('BR')
                                                    <span class="badge badge-primary">Mengikuti Ujian</span>
                                                    @break

                                                @case('OP')
                                                    <span class="badge badge-info">Sedang Proses</span>
                                                    @break

                                                @case('FN')
                                                    <a href="{{ url($url . '/' . $ujianHarianSiswa->ujian_harian_hasil_id . '/hasil') }}" class="badge badge-success" target="_blank">Lihat Hasil</a>
                                                    @break

                                                @case('CL')
                                                    <span class="badge badge-danger">Tidak Diizinkan</span>
                                                    @break

                                                @default
                                                    No Defined
                                            @endswitch
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
</div>
@endsection

@section('addModal')

@endsection