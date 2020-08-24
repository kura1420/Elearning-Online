@extends('layouts.app')

@section('titlePage') Soal @endsection

@section('addTitle') | Soal @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="https://cdn.tiny.cloud/1/8ad32uo2ibgfvsn8a9zxh9vbg5yw2jfpibw0gjiwzvdqata8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/soal/create.js') }}"></script>
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
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
                                        <select name="kelas" id="kelas" class="form-control" required>
                                            <option value="">- Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mata_pelajaran">Mata Pelajaran<span class="text-danger">*</span></label>
                                        <select name="mata_pelajaran" id="mata_pelajaran" class="form-control" required>
                                            <option value="">- Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pelajaran_tipe">Tipe Pelajaran <span class="text-danger">*</span></label>                                    
                                        <select name="pelajaran_tipe" id="pelajaran_tipe" class="form-control">
                                            <option value="">- Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran">Judul<span class="text-danger">*</span></label>
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="tipe">Tipe <span class="text-danger">*</span></label>
                                        <select name="tipe" id="tipe" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="pg">Pilihan Ganda</option>
                                            <option value="es">Essay</option>
                                            <!-- <option value="cu">Custom</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipe_pilihan_ganda">Tipe Pilihan Ganda</label>
                                        <select name="tipe_pilihan_ganda" id="tipe_pilihan_ganda" class="form-control" disabled>
                                            <option value="">- Pilih -</option>
                                            <option value="a-d">A - D</option>
                                            <option value="a-e">A - E</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="rumus_penilaian_ujian">Rumus Penilaian<span class="text-danger">*</span></label>
                                        <select name="rumus_penilaian_ujian" id="rumus_penilaian_ujian" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach ($rumusPenilaianUjians as $rumusPenilaianUjian)
                                            <option value="{{ $rumusPenilaianUjian->id }}">{{ $rumusPenilaianUjian->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="publish">Publish <span class="text-danger">*</span></label>
                                    <select name="publish" id="publish" class="form-control">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="instruksi">Instruksi</label>
                                <textarea name="instruksi" id="instruksi" cols="30" rows="5"></textarea>
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