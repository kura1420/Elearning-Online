@extends('layouts.app')

@section('titlePage') Siswa @endsection

@section('addTitle') | Siswa @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script src="{{ asset('assets/js/sekolah/siswa/create.js') }}"></script>
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
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nomor_induk">Nomor Induk<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nomor_induk') is-invalid @enderror" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}" placeholder="Nomor Induk" autofocus> 
                                            
                                            @error('nomor_induk')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Siswa"> 
                                            
                                            @error('nama')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                                <option value="">- Pilih -</option>
                                                <option value="l" {{ old( 'jenis_kelamin') == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="p" {{ old( 'jenis_kelamin') == 'p' ? 'selected' : '' }}>Perempuan</option>
                                            </select>

                                            @error('jenis_kelamin')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir"> 
                                            
                                            @error('tanggal_lahir')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir"> 
                                            
                                            @error('tempat_lahir')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                        
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="handphone">Handphone</label>
                                            <input type="text" class="form-control @error('handphone') is-invalid @enderror" id="handphone" name="handphone" value="{{ old('handphone') }}" placeholder="Handphone"> 
                                            
                                            @error('handphone')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="telp">Telp.</label>
                                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ old('telp') }}" placeholder="Telp."> 
                                            
                                            @error('telp')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email"> 
                                            
                                            @error('email')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                            
                                            @error('alamat')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stacked-form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                        @foreach ($tahunAjarans as $tahunAjaran)
                                        <option value="{{ $tahunAjaran->id }}" {{ old('tahun_ajaran') == $tahunAjaran->id ? 'selected' : '' }}> {{ $tahunAjaran->merge_periode . '/' . ucfirst($tahunAjaran->semester) }} </option>
                                        @endforeach
                                    </select>
                                    
                                    @error('tahun_ajaran')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kelas">Kelas<span class="text-danger">*</span></label>
                                    <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                        <option value="">- Pilih -</option>
                                    </select>
                                    
                                    @error('kelas')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan"> 
                                    
                                    @error('keterangan')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-sm">
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