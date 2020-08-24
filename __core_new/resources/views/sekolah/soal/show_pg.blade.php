@extends('layouts.app')

@section('titlePage') Soal @endsection

@section('addTitle') | Soal @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/soal/show_pg.js') }}"></script>
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
                                        <input type="hidden" name="soal_id" id="soal_id" value="{{ $soal->id }}">
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
                                        <label for="tipe_pilihan_ganda">Tipe Pilihan Ganda</label>
                                        <input type="text" name="tipe_pilihan_ganda" id="tipe_pilihan_ganda" class="form-control" value="{{ strtoupper($soal->tipe_pilihan_ganda) }}" disabled>
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

                            <a href="{{ url('/sch/pertanyaan/create?soal=' . $soal->id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-pencil"></i> Tambah
                            </a>

                            <a href="{{ url($url . '/' . $soal->id . '/import-pertanyaan') }}" class="btn btn-info btn-sm">
                                <i class="fa fa-edit"></i> Import Pertanyaan
                            </a>

                            <a href="{{ url($url . '/' . $soal->id . '/import-pertanyaan-jawaban') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-list"></i> Import Jawaban
                            </a>

                            <button type="button" class="btn btn-sm btn-danger" id="btnCopyPertanyaan">
                                <i class="fa fa-copy"></i> Copy Pertanyaan
                            </button>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width:5%;">No.</th>
                                        <th scope="col" style="width:75%;">Pertanyaan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($soalPertanyaans as $soalPertanyaan)
                                    <tr class="{{ $soalPertanyaan->id }}">
                                        <th scope="row">{{ $loop->iteration }}.</th>
                                        <td>@php echo $soalPertanyaan->pertanyaan; @endphp</td>
                                        <td>
                                            <a href="{{ url('/sch/pertanyaan/' . $soalPertanyaan->id . '/edit') }}" class="btn btn-link btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                                            <button type="button" class="btn btn-link btn-danger btnRemove" value="{{ $soalPertanyaan->id }}" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="{{ $soalPertanyaan->id }}">
                                        <th scope="row"></th>
                                        <td colspan="2">
                                            @php
                                            $jawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $soalPertanyaan->id)->orderBy('urutan', 'asc')->get();
                                            @endphp

                                            <table class="table-striped" width="100%" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">#</th>
                                                        <th style="width:85%">Jawaban</th>
                                                        <th>Kunci</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jawabans as $jawaban)
                                                    <tr>
                                                        <td>{{ $jawaban->urutan }}.</td>
                                                        <td>@php echo $jawaban->jawaban; @endphp</td>
                                                        <td>
                                                            @if ($jawaban->benar == 1)
                                                                <i class="fa fa-check text-success"></i> 
                                                            @else
                                                                <i class="fa fa-times text-danger"></i> 
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
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
<div class="modal fade" id="modalCopyPertanyaan" tabindex="-1" role="dialog" aria-labelledby="modalCopyPertanyaan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header btn-danger">
                <h5 class="modal-title">Copy Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-striped table-no-bordered table-hover dataTable dtr-inline">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-control">
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
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pelajaran">Pelajaran<span class="text-danger">*</span></label>
                            <select name="pelajaran" id="pelajaran" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pelajaran_tipe">Tipe Pelajaran<span class="text-danger">*</span></label>
                            <select name="pelajaran_tipe" id="pelajaran_tipe" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="soal">Soal<span class="text-danger">*</span></label>
                            <select name="soal" id="soal" class="form-control">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <input type="button" value="Load Pertanyaan" class="btn btn-sm btn-danger" id="btnLoadPertanyaan" style="margin-top:40%;">
                    </div>
                </div>

                <hr>

                <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:8%;">No.</th>
                            <th>Pertanyaan</th>
                            <th style="width:10%">Tipe Soal</th>
                            <th style="width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCopyPertanyaanCheck">Copy</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection