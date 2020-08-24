@extends('layouts.app')

@section('titlePage') User @endsection

@section('addTitle') | User @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarMasterData').addClass('show');
    $('#sidebarUser').addClass('active');
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
                                    <label for="nama_lengkap">{{ __('Nama Lengkap') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" autofocus>

                                    @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">{{ __('Username') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Username">

                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">

                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tingkat">{{ __('Tingkat') }} <span class="text-danger">*</span></label>
                                    <select name="tingkat" id="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        <option value="rot" {{ old('tingkat') == 'rot' ? 'selected' : NULL }}>Administrator</option>
                                        <option value="mkt" {{ old('tingkat') == 'mkt' ? 'selected' : NULL }}>Marketing</option>
                                    </select>

                                    @error('tingkat')
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