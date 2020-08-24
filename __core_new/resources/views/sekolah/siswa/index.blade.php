@extends('layouts.app')

@section('titlePage') Siswa @endsection

@section('addTitle') | Siswa @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/siswa/index.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (\Session::has('success'))
                <div class="alert alert-primary">
                    <b> Info! </b> {{ \Session::get('success') }}</span>
                </div>
                @endif

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
                                <div class="col-sm-7">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnFilter">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>

                                    <a href="{{ url($url . '/create') }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> Tambah
                                    </a>

                                    <a href="{{ url($url . '/import') }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> Import
                                    </a>
                                </div>
                            </div>

                            <br>

                            <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Kelas</th>
                                        <th>Keterangan</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Induk</th>
                                        <th>Nama</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Kelas</th>
                                        <th>Keterangan</th>
                                        <th width="150px">Aksi</th>
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