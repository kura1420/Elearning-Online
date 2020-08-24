@extends('layouts.app')

@section('titlePage') Ujian Harian @endsection

@section('addTitle') | Ujian Harian @endsection

@section('addCss')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/clockpicker-gh-pages/dist/bootstrap-clockpicker.min.css') }}">
@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/clockpicker-gh-pages/dist/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/ujian_harian/create.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-header">
                        <h4 class="card-title">
                                Form Data
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>

                                <button type="button" class="btn btn-sm btn-primary" id="btnSave">
                                    <i class="fa fa-check"></i> Simpan
                                </button>
                            </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                                        <option value="">- Pilih -</option>
                                        @foreach ($tahunAjarans as $tahunAjaran)
                                        <option value="{{ $tahunAjaran->id }}"> {{ $tahunAjaran->merge_periode . '/' . ucfirst($tahunAjaran->semester) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>           
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas<span class="text-danger">*</span></label>
                                    <select name="kelas" id="kelas" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran">Pelajaran<span class="text-danger">*</span></label>
                                    <select name="pelajaran" id="pelajaran" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pelajaran_tipe">Tipe Pelajaran<span class="text-danger">*</span></label>
                                    <select name="pelajaran_tipe" id="pelajaran_tipe" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="soal">Soal<span class="text-danger">*</span></label>
                                    <select name="soal" id="soal" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="judul">Judul<span class="text-danger">*</span></label>
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul">
                                </div>
                            </div> -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai<span class="text-danger">*</span></label>
                                    <input type="text" name="waktu_mulai" id="waktu_mulai" class="form-control" data-autoclose="true" placeholder="Waktu Mulai">
                                </div>
                            </div>  
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="waktu_habis">Waktu Habis<span class="text-danger">*</span></label>
                                    <input type="text" name="waktu_habis" id="waktu_habis" class="form-control" data-autoclose="true" placeholder="Waktu Habis">
                                </div>
                            </div>   
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal">
                                </div>
                            </div>
                        </div>

                        <div class="row">                      
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="alert_simpan_jawaban">Alert Simpan Jwb<span class="text-danger">*</span></label>
                                    <input type="text" name="alert_simpan_jawaban" id="alert_simpan_jawaban" class="form-control" placeholder="Alert Simpan Jwb">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="tampilkan_nilai">Tampilkan Nilai<span class="text-danger">*</span></label>
                                    <select name="tampilkan_nilai" id="tampilkan_nilai" class="form-control">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="batas_kelulusan">Batas Kelulusan</label>
                                    <input type="text" name="batas_kelulusan" id="batas_kelulusan" class="form-control" placeholder="Batas Kelulusan" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="jenis_ujian">Jenis Ujian<span class="text-danger">*</span></label>
                                    <select name="jenis_ujian" id="jenis_ujian" class="form-control">
                                        <option value="">- Pilih -</option>
                                        @foreach ($jenisUjians as $jenisUjian)
                                        <option value="{{ $jenisUjian->id }}">{{ $jenisUjian->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pertanyaan_acak">Pertanyaan Acak<span class="text-danger">*</span></label>
                                    <select name="pertanyaan_acak" id="pertanyaan_acak" class="form-control">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-body">
                        <div class="row">                        
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="getKelas" id="getKelas" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-info" id="btnGetDataSiswa">
                                    <i class="fa fa-filter"></i> Get Data Siswa
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline">
                        <div class="fresh-datatables">
                            <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama Lengkap</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama Lengkap</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                
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