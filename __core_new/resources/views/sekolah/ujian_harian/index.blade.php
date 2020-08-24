@extends('layouts.app')

@section('titlePage') Ujian Harian @endsection

@section('addTitle') | Ujian Harian @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/ujian_harian/index.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="fresh-datatables" style="margin:2%;">
                            <div class="row">
                                <div class="col-sm-3">
                                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                                        <option value="">- Pilih Tahun Ajaran -</option>
                                        @foreach ($tahunAjarans as $tahunAjaran)
                                        <option value="{{ $tahunAjaran->id }}"> {{ $tahunAjaran->merge_periode . '-' . $tahunAjaran->semester }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="kelas" id="kelas" class="form-control">
                                        <option value="">- Pilih Kelas -</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select name="jenis_ujian" id="jenis_ujian" class="form-control">
                                        <option value="">- Pilih Jenis Ujian -</option>
                                        @foreach ($jenisUjians as $jenisUjian)
                                        <option value="{{ $jenisUjian->id }}">{{ $jenisUjian->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnFilter">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>

                                    <a href="{{ url($url . '/create') }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> Tambah
                                    </a>
                                </div>
                            </div>

                            <br>

                            <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <!-- <th>Judul</th> -->
                                        <th>Tanggal</th>
                                        <th>Soal</th>
                                        <th>Pelajaran</th>
                                        <th>Tipe Pelajaran</th>
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
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection