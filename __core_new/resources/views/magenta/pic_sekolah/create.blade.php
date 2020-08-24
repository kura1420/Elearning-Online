@extends('layouts.app')

@section('titlePage') Pic Sekolah @endsection

@section('addTitle') | Pic Sekolah @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/bootstrap-selectpicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script>
$(function () {
    $('#sidebarMasterData').addClass('show');
    $('#sidebarPicSekolah').addClass('active');

    $('#handphone, #telp').numeric();
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <form action="{{ url($url) }}" method="post" autocomplete="off">
        @csrf
            <div class="row">
                <div class="col-md-8">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">{{ __('Nama Lengkap') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama Lengkap" autofocus> 
                                        
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email"> 
                                        
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="handphone">{{ __('Handphone') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="handphone" id="handphone" class="form-control @error('handphone') is-invalid @enderror" value="{{ old('handphone') }}" placeholder="Handphone"> 
                                        
                                        @error('handphone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telp">{{ __('Telp.') }}</label>
                                        <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" placeholder="Telp." value="{{ old('telp') }}"> 
                                        
                                        @error('telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">{{ __('Jabatan') }}</label>
                                        <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Jabatan" value="{{ old('jabatan') }}"> 
                                        
                                        @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sekolah">{{ __('Sekolah') }} <span class="text-danger">*</span></label>
                                        <select name="sekolah" id="sekolah" class="selectpicker" data-title="Pilih" data-style="btn-warning btn-outline" data-menu-style="dropdown-blue" data-live-search="true">
                                            @foreach ($sekolahs as $sekolah)
                                            <option value="{{ $sekolah->id }}" {{ old('sekolah') == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama }}</option>
                                            @endforeach
                                        </select>

                                        @error('sekolah')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat">{{ __('Alamat') }}</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat') }}</textarea>

                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">
                                Akses Login
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">

                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">

                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-check"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('addModal')

@endsection