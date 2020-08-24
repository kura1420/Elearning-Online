@extends('layouts.app')

@section('titlePage') Pertanyaan @endsection

@section('addTitle') | Pertanyaan @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="https://cdn.tiny.cloud/1/8ad32uo2ibgfvsn8a9zxh9vbg5yw2jfpibw0gjiwzvdqata8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/soal_pertanyaan/edit_es.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="alert alert-warning" role="alert" id="alertSuccess" style="display:none;">
                <strong>Informasi</strong> Pertanyaan berhasil tersimpan.
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">No. <strong id="nomor">{{ $soalPertanyaan->nomor }}</strong></h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id" id="id" value="{{ $soalPertanyaan->id }}">
                            <input type="hidden" name="soal" id="soal" value="{{ $soalPertanyaan->soal_id }}">
                            <textarea name="pertanyaan" id="pertanyaan" cols="30" rows="10">{{ $soalPertanyaan->pertanyaan }}</textarea>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-primary" id="btnSave">
                                <i class="fa fa-check"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stacked-form">
                        <div class="card-header">
                            Soal

                            <a href="{{ url('sch/soal/' . $soal->id) }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>

                            <button type="button" class="btn btn-sm btn-primary" id="btnNewWindow">
                                <i class="fa fa-folder"></i> Ke Gallery File
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tahun_ajaran_id">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control" value="{{ $soal->tahun_ajaran_id }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>
                                <input type="text" name="kelas_id" id="kelas_id" class="form-control" value="{{ $soal->kelas_id }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="pelajaran_id">Pelajaran</label>
                                <input type="text" name="pelajaran_id" id="pelajaran_id" class="form-control" value="{{ $soal->pelajaran_id }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="pelajaran_tipe_id">Tipe Pelajaran</label>
                                <input type="text" name="pelajaran_tipe_id" id="pelajaran_tipe_id" class="form-control" value="{{ $soal->pelajaran_tipe_id }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="tipe">Tipe Soal</label>
                                <input type="text" name="tipe" id="tipe" class="form-control" value="{{ $soal->tipe_convert }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="publish">Publish</label>
                                <input type="text" name="publish" id="publish" class="form-control" value="{{ $soal->publish == 1 ? 'Ya' : 'Tidak' }}" disabled>
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