@extends('layouts.app')

@section('titlePage') Pelajaran @endsection

@section('addTitle') | Pelajaran @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarPelajaran').addClass('active');
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
                                Form Data
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url($url . '/' . $row->id) }}" method="post" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">{{ __('Nama') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $row->nama }}" placeholder="Nama" autofocus>

                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">{{ __('Keterangan') }}</label>
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control @error('email') is-invalid @enderror" placeholder="Keterangan">{{ $row->keterangan }}</textarea>

                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-check"></i> Simpan
                                    </button>
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