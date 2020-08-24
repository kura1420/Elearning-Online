@extends('layouts.app')

@section('titlePage') Guru @endsection

@section('addTitle') | Guru @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarGuru').addClass('active');

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
                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">
                                Import Data
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url($url . '/import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">{{ __('Import Profile Guru') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}" placeholder="Import Profile Guru">

                                    @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary" id="btnSubmit">
                                        <i class="fa fa-check"></i> Simpan
                                    </button>

                                    <a href="{{ asset('template/guru.xlsx') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-download"></i> Download Template Import
                                    </a>
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