@extends('layouts.app')

@section('titlePage') Profil Sekolah @endsection

@section('addTitle') | Profil Sekolah @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script src="{{ asset('assets/js/helper.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/profil_sekolah/index.js') }}"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card stacked-form">
                    <div class="card-header">
                        <h4 class="card-title">
                            Profil Sekolah
                            <button type="button" class="btn btn-sm btn-primary" id="btnSave">
                                <i class="fa fa-check"></i> Simpan
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nama">Nama Profil Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Profil Sekolah" autofocus value="{{ $row->nama }}">
                                        <input type="hidden" name="id" id="id" value="{{ $row->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="npsn">NSPN</label>
                                        <input type="text" name="npsn" id="npsn" class="form-control" placeholder="NSPN" value="{{ $row->npsn }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="swasta" {{ $row->status == 'swasta' ? 'selected' : '' }}>Swasta</option>
                                            <option value="negeri" {{ $row->status == 'negeri' ? 'selected' : '' }}>Negeri</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                                        <select name="pendidikan" id="pendidikan" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="sd" {{ $row->pendidikan == 'sd' ? 'selected' : '' }}>SD</option>
                                            <option value="smp" {{ $row->pendidikan == 'smp' ? 'selected' : '' }}>SMP</option>
                                            <option value="sma" {{ $row->pendidikan == 'sma' ? 'selected' : '' }}>SMA</option>
                                            <option value="smk" {{ $row->pendidikan == 'smk' ? 'selected' : '' }}>SMK</option>
                                            <option value="universitas" {{ $row->pendidikan == 'universitas' ? 'selected' : '' }}>Universitas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telp">Telp.</label>
                                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Telp." value="{{ $row->telp }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="fax">Fax</label>
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax" value="{{ $row->fax }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $row->email }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value="{{ $row->alamat }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    <input type="hidden" name="logo" id="logo" value="{{ $row->logo }}">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button type="button" class="btn btn-sm btn-success" id="btnUploadFile">
                                        <i class="fa fa-upload"></i> Upload File
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger" id="btnRemoveFile" style="display:none;">
                                        <i class="fa fa-trash"></i> Hapus File
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection