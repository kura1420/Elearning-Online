@extends('layouts.app')

@section('titlePage') Pertanyaan @endsection

@section('addTitle') | Pertanyaan @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="https://cdn.tiny.cloud/1/8ad32uo2ibgfvsn8a9zxh9vbg5yw2jfpibw0gjiwzvdqata8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/soal_pertanyaan/create_pg.js') }}"></script>
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
                            <h4 class="card-title">No. <strong id="nomor"></strong></h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="soal" id="soal" value="{{ $soal->id }}">
                            <input type="hidden" name="tipe" id="tipe" value="{{ $soal->tipe }}">
                            <textarea name="pertanyaan" id="pertanyaan" cols="30" rows="10"></textarea>
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
                                <label for="tipe_pilihan_ganda">Tipe Pilihan Ganda</label>
                                <input type="text" name="tipe_pilihan_ganda" id="tipe_pilihan_ganda" class="form-control" value="{{ strtoupper($soal->tipe_pilihan_ganda) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="publish">Publish</label>
                                <input type="text" name="publish" id="publish" class="form-control" value="{{ $soal->publish == 1 ? 'Ya' : 'Tidak' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <div class="form-group row">
                                <label for="kunci_jawaban" class="col-sm-2 col-form-label">Kunci Jawaban</label>
                                <div class="col-sm-2">
                                    <select name="kunci_jawaban" id="kunci_jawaban" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>
                                        <option value="e" style="{{ $soal->tipe_pilihan_ganda !== 'a-e' ? 'display:none;' : '' }}">E</option>
                                    </select>
                                </div>
                            </div>                          
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="jawaban_a" class="col-sm-1 col-form-label">A.</label>
                                <div class="col-sm-11">
                                    <textarea name="jawaban_a" id="jawaban_a" cols="30" rows="10" class="jawaban"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_b" class="col-sm-1 col-form-label">B.</label>
                                <div class="col-sm-11">
                                    <textarea name="jawaban_b" id="jawaban_b" cols="30" rows="10" class="jawaban"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_c" class="col-sm-1 col-form-label">C.</label>
                                <div class="col-sm-11">
                                    <textarea name="jawaban_c" id="jawaban_c" cols="30" rows="10" class="jawaban"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_d" class="col-sm-1 col-form-label">D.</label>
                                <div class="col-sm-11">
                                    <textarea name="jawaban_d" id="jawaban_d" cols="30" rows="10" class="jawaban"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" style="{{ $soal->tipe_pilihan_ganda !== 'a-e' ? 'display:none;' : '' }}">
                                <label for="jawaban_e" class="col-sm-1 col-form-label">E.</label>
                                <div class="col-sm-11">
                                    <textarea name="jawaban_e" id="jawaban_e" cols="30" rows="10" class="jawaban"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-primary" id="btnSave">
                                <i class="fa fa-check"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('addModal')

@endsection