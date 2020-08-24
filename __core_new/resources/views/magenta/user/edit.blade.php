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
                            <form action="{{ url($url . '/' . $row->id) }}" method="post" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama_lengkap">{{ __('Nama Lengkap') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ $row->name }}" placeholder="Nama Lengkap" autofocus>

                                    @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $row->email }}" placeholder="Email">

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">{{ __('Username') }} </label>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ $row->username }}" placeholder="Username" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">

                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="tingkat">{{ __('Tingkat') }} <span class="text-danger">*</span></label>
                                            <select name="tingkat" id="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
                                                <option value="">- Pilih -</option>
                                                <option value="rot" {{ $row->level == 'rot' ? 'selected' : NULL }}>Administrator</option>
                                                <option value="mkt" {{ $row->level == 'mkt' ? 'selected' : NULL }}>Marketing</option>
                                            </select>

                                            @error('tingkat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $row->active == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ $row->active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i> Perbarui
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