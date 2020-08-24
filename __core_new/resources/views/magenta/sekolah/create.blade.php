@extends('layouts.app')

@section('titlePage') Sekolah @endsection

@section('addTitle') | Sekolah @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script src="{{ asset('assets/js/helper.js') }}"></script>
<script src="{{ asset('assets/js/magenta/sekolah/create.js') }}"></script>
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
                        <form action="#" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nama">Nama Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Sekolah" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="npsn">NSPN</label>
                                        <input type="text" name="npsn" id="npsn" class="form-control" placeholder="NSPN">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="swasta">Swasta</option>
                                            <option value="negeri">Negeri</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                                        <select name="pendidikan" id="pendidikan" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="sd">SD</option>
                                            <option value="smp">SMP</option>
                                            <option value="sma">SMA</option>
                                            <option value="smk">SMK</option>
                                            <option value="universitas">Universitas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telp">Telp.</label>
                                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Telp.">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="fax">Fax</label>
                                    <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax">
                                </div>
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat">
                                </div>
                                <div class="col-md-4">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    <input type="hidden" name="logo" id="logo">
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

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            PIC
                            <button type="button" class="btn btn-sm btn-warning" id="btnAddPic">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Handphone</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableListPic">
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
<div class="modal fade" id="modalPic" tabindex="-1" role="dialog" aria-labelledby="modalLabelPIC" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelPIC">Form PIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_nama">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="modal_nama" id="modal_nama" class="form-control" placeholder="Nama">
                            </div>

                            <div class="form-group">
                                <label for="modal_email">Email</label>
                                <input type="email" name="modal_email" id="modal_email" class="form-control" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <label for="modal_handphone">Handphone <span class="text-danger">*</span></label>
                                <input type="text" name="modal_handphone" id="modal_handphone" class="form-control" placeholder="Handphone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_telp">Telp</label>
                                <input type="text" name="modal_telp" id="modal_telp" class="form-control" placeholder="Telp">
                            </div>

                            <div class="form-group">
                                <label for="modal_alamat">Alamat</label>
                                <input type="text" name="modal_alamat" id="modal_alamat" class="form-control" placeholder="Alamat">
                            </div>

                            <div class="form-group">
                                <label for="modal_jabatan">Jabatan</label>
                                <input type="text" name="modal_jabatan" id="modal_jabatan" class="form-control" placeholder="Jabatan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                <button type="button" class="btn btn-sm btn-info" id="btnSavePic"><i class="fa fa-pencil"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection