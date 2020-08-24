@extends('layouts.app')

@section('titlePage') File Upload @endsection

@section('addTitle') | File Upload @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/file_upload/create.js') }}"></script>
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
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="random_nama">Random Nama<span class="text-danger">*</span></label>
                                        <select name="random_nama" id="random_nama" class="form-control">
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="tipe">Tipe File<span class="text-danger">*</span></label>
                                        <select name="tipe" id="tipe" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="image">Gambar</option>
                                            <option value="video">Video</option>
                                            <option value="audio">Suara</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="folder">Folder<span class="text-danger">*</span></label>
                                        <select name="folder" id="folder" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="soal_pertanyaan">Pertanyaan</option>
                                            <option value="soal_pertanyaan_jawaban">Jawaban</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="file">File upload<span class="text-danger">*</span></label>
                                        <input type="file" name="file" id="file" class="form-control">
                                        <div class="progress" id="progress-header">
                                            <div class="progress-bar progress-bar-aqua" id="progress-child" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="url">URL File</label>
                                        <input type="text" name="url" id="url" class="form-control" readonly>
                                        <small id="info" class="form-text text-danger">* Tunggu hingga ada informasi upload file berhasil.</small>
                                    </div>
                                </div>
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