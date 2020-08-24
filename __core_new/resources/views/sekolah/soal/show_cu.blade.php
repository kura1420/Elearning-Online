@extends('layouts.app')

@section('titlePage') Soal @endsection

@section('addTitle') | Soal @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sekolah/soal/show_es.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <b> Info! </b> {{ \Session::get('success') }}</span>
                    </div>
                    @endif

                    <div class="alert alert-primary">
                        <b> Instruksi: </b> @php echo $soal->instruksi; @endphp</span>
                    </div>

                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ $soal->judul }}
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                                <a href="{{ url($url . '/' . $soal->id . '/edit') }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                                        <input type="text" name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control" value="{{ $soal->tahun_ajaran_id }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="kelas_id">Kelas</label>
                                        <input type="text" name="kelas_id" id="kelas_id" class="form-control" value="{{ $soal->kelas_id }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pelajaran_id">Pelajaran</label>
                                        <input type="text" name="pelajaran_id" id="pelajaran_id" class="form-control" value="{{ $soal->pelajaran_id }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pelajaran_tipe_id">Tipe Pelajaran</label>
                                        <input type="text" name="pelajaran_tipe_id" id="pelajaran_tipe_id" class="form-control" value="{{ $soal->pelajaran_tipe_id }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipe">Tipe Soal</label>
                                        <input type="text" name="tipe" id="tipe" class="form-control" value="{{ $soal->tipe }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rumus_penilaian_ujian">Rumus Penilaian</label>
                                        <input type="text" name="rumus_penilaian_ujian" id="rumus_penilaian_ujian" class="form-control" value="{{ strtoupper($soal->rumus_penilaian_ujian) }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="publish">Publish</label>
                                        <input type="text" name="publish" id="publish" class="form-control" value="{{ $soal->publish == 1 ? 'Ya' : 'Tidak' }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            List Pertanyaan 
                            <a href="#" class="btn btn-success btn-sm">
                                <i class="fa fa-pencil"></i> Tambah
                            </a>
                        </div>
                        <div class="card-body">
                            <h4>CRUD Pertanyaan Belum Tersedia.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('addModal')

@endsection