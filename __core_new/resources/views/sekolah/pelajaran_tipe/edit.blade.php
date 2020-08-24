@extends('layouts.app')

@section('titlePage') Pelajaran Tipe @endsection

@section('addTitle') | Pelajaran Tipe @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/bootstrap-selectpicker.js') }}" type="text/javascript"></script>
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarPelajaranTipe').addClass('active');
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
                                    <label for="pelajaran">Pelajaran <span class="text-danger">*</span></label>
                                    <select name="pelajaran" id="pelajaran" class="selectpicker" data-title="Pilih" data-style="btn-warning btn-outline" data-menu-style="dropdown-blue" data-live-search="true">
                                        @foreach ($pelajarans as $pelajaran)
                                        <option value="{{ $pelajaran->id }}" {{ $row->pelajaran_id == $pelajaran->id ? 'selected' : '' }}>{{ $pelajaran->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('pelajaran')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $row->nama }}">

                                    @error('nama')
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