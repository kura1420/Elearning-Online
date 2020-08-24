@extends('layouts.app')

@section('titlePage') Jenis Ujian @endsection

@section('addTitle') | Jenis Ujian @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarPengaturan').addClass('show');
    $('#sidebarJenisUjian').addClass('active');
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
                            <form action="{{ url($url) }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="jenis">{{ __('Jenis') }}</label>
                                    <select name="jenis" id="jenis" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="harian" {{ old('jenis') == 'harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="mingguan" {{ old('jenis') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    </select>

                                    @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama">{{ __('Nama') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama" autofocus>

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