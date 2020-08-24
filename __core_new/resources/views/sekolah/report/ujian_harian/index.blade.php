@extends('layouts.app')

@section('titlePage') Report Ujian Harian @endsection

@section('addTitle') | Report Ujian Harian @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/report/ujian_harian/index.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
                <h4 class="card-title">Report Ujian Harian</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
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
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pelajaran">Pelajaran</label>
                            <select name="pelajaran" id="pelajaran" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pelajaran_tipe">Tipe Pelajaran</label>
                            <select name="pelajaran_tipe" id="pelajaran_tipe" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="soal">Soal</label>
                            <select name="soal" id="soal" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="jenis_ujian">Jenis Ujian</label>
                            <select name="jenis_ujian" id="jenis_ujian" class="form-control">
                                <option value="">- Pilih -</option>
                                @foreach ($jenisUjians as $jenisUjian)
                                <option value="{{ $jenisUjian->id }}">{{ $jenisUjian->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tanggal_ujian">Tanggal Ujian</label>
                            <select name="tanggal_ujian" id="tanggal_ujian" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-primary" id="btnFilter">
                    <i class="fa fa-filter"></i> Filter
                </button>

                <a href="#" class="btn btn-sm btn-success" id="btnExportSummary" target="_blank">
                    <i class="fa fa-download"></i> Export Summary
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Total Pertanyaan</th>
                            <th>Nilai</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection