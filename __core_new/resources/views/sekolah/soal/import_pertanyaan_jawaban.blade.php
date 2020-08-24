@extends('layouts.app')

@section('titlePage') Import Jawaban @endsection

@section('addTitle') | Import Jawaban @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarSoal').addClass('active');

    $('#btnSubmit').on('click', function () {
        $('#_loader_').addClass('is-active');
    });
});
</script>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary">
                        <b> Instruksi: </b> 
                        <ol>
                            <li>File yang digunakan hanya Excel.</li>
                            <li>Format import sudah tersedia, silahkan download dan ikuti format yang sudah ada.</li>
                            <li>Dilarang melakukan perubahan format.</li>
                            <li>Data yang ada di excel hanya text saja, tidak disarankan untuk yang lain seperti gambar atau karakter diluar text.</li>
                        </ol>
                    </div>

                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">
                                Import Data
                                <a href="{{ url('sch/soal/' . $row->id) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url($url . '/' . $row->id . '/import-pertanyaan-jawaban') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">{{ __('Import Jawaban') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}" placeholder="Import Jawaban">

                                    @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary" id="btnSubmit">
                                        <i class="fa fa-check"></i> Simpan
                                    </button>

                                    @if ($row->tipe_pilihan_ganda == 'a-d')
                                    <a href="{{ asset('template/soal_pertanyaan_jawaban.xlsx') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-download"></i> Download Template Import
                                    </a>
                                    @else
                                    <a href="{{ asset('template/soal_pertanyaan_jawaban_e.xlsx') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-download"></i> Download Template Import
                                    </a>
                                    @endif
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