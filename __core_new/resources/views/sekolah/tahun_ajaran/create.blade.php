@extends('layouts.app')

@section('titlePage') Tahun Ajaran @endsection

@section('addTitle') | Tahun Ajaran @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/tahun_ajaran/create.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <form action="#" method="post" autocomplete="off">
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
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="periode_awal">Periode Awal<span class="text-danger">*</span></label>
                                            <select name="periode_awal" id="periode_awal" class="form-control">
                                                <option value="">- Pilih -</option>
                                                @for ($i=date('Y') - 5; $i<date('Y') + 5; $i++)
                                                <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}> {{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="periode_akhir">Periode Akhir<span class="text-danger">*</span></label>
                                            <select name="periode_akhir" id="periode_akhir" class="form-control">
                                                <option value="">- Pilih -</option>
                                                @for ($i=date('Y') - 5; $i<date('Y') + 5; $i++)
                                                <option value="{{ $i }}" {{ (date('Y')+1) == $i ? 'selected' : '' }}> {{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="semester">Semester<span class="text-danger">*</span></label>
                                            <select name="semester" id="semester" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="ganjil">Ganjil</option>
                                                <option value="genap">Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card stacked-form">
                            <div class="card-header">
                                <h4 class="card-title">List Mata Pelajaran & Guru</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-pills" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                        @foreach ($kelas as $key => $kls)
                                            <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="vert-tabs-{{ strtolower(str_replace(' ', '-', $kls->nama)) }}-tab" data-toggle="pill" href="#vert-tabs-{{ strtolower(str_replace(' ', '-', $kls->nama)) }}" role="tab" aria-controls="vert-tabs-{{ strtolower(str_replace(' ', '-', $kls->nama)) }}" aria-selected="false">Kelas {{ $kls->nama }}</a>
                                        @endforeach
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                        @foreach ($kelas as $key => $kls)
                                            <div class="tab-pane text-left fade show {{ $key == 0 ? 'active' : '' }}" id="vert-tabs-{{ strtolower(str_replace(' ', '-', $kls->nama)) }}" role="tabpanel" aria-labelledby="vert-tabs-{{ strtolower(str_replace(' ', '-', $kls->nama)) }}-tab">
                                                <div class="form-group row">
                                                    <label for="mata_pelajaran_{{ $kls->id }}" class="col-form-label">Mata Pelajaran</label>
                                                    <div class="col-sm-3">
                                                        <select name="{{ $kls->id }}" id="{{ $kls->id }}" class="form-control selectMataPelajaran">
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($pelajarans as $p)
                                                            <option value="{{ $p->id }}"> {{ $p->nama }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <label for="guru_{{ $kls->id }}" class="col-form-label">Guru</label>
                                                    <div class="col-sm-3">
                                                        <select name="guru_{{ $kls->id }}" id="guru_{{ $kls->id }}" class="form-control">
                                                            <option value="">- Pilih -</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <button type="button" class="btn btn-success btn-sm btnAddMataPelajaran" value="{{ $kls->id }}">
                                                            <i class="fa fa-plus"></i> Tambah
                                                        </button>
                                                    </div>
                                                </div>

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Mata Pelajaran</th>
                                                            <th>Guru</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table_{{ $kls->id }}">

                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('addModal')

@endsection