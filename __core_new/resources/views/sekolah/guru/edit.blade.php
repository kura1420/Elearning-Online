@extends('layouts.app')

@section('titlePage') Guru @endsection

@section('addTitle') | Guru @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-selectpicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery-number/jquery.numeric.min.js') }}"></script>
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarGuru').addClass('active');

    $('.datepicker').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    $('#handphone, #telp').numeric();
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <form action="{{ url($url . '/' . $row->id) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
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
                                        <label for="nomor_induk">Nomor Induk</label>
                                        <input type="text" class="form-control @error('nomor_induk') is-invalid @enderror" id="nomor_induk" name="nomor_induk" value="{{ $row->nomor_induk }}" placeholder="Nomor Induk" autofocus> 
                                        
                                        @error('nomor_induk')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Nama<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $row->nama }}" placeholder="Nama Guru"> 
                                        
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
                                            <option value="l" {{ $row->jenis_kelamin == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="p" {{ $row->jenis_kelamin == 'p' ? 'selected' : '' }}>Perempuan</option>
                                        </select>

                                        @error('jenis_kelamin')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="text" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ isset($row->tanggal_lahir) ? date('d-m-Y', strtotime($row->tanggal_lahir)) : NULL }}" placeholder="Tanggal Lahir"> 
                                        
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ $row->tempat_lahir }}" placeholder="Tempat Lahir"> 
                                        
                                        @error('tempat_lahir')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="handphone">Handphone<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('handphone') is-invalid @enderror" id="handphone" name="handphone" value="{{ $row->handphone }}" placeholder="Handphone"> 
                                        
                                        @error('handphone')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="telp">Telp.</label>
                                        <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ $row->telp }}" placeholder="Telp."> 
                                        
                                        @error('telp')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $row->email }}" placeholder="Email"> 
                                        
                                        @error('email')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tanggal_masuk">Tanggal Masuk</label>
                                        <input type="text" class="form-control datepicker @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk" name="tanggal_masuk" value="{{ isset($row->tanggal_masuk) ? date('d-m-Y', strtotime($row->tanggal_masuk)) : NULL }}" placeholder="Tanggal Masuk"> 
                                        
                                        @error('tanggal_masuk')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tanggal_keluar">Tanggal Keluar</label>
                                        <input type="text" class="form-control @error('tanggal_keluar') is-invalid @enderror" id="tanggal_keluar" name="tanggal_keluar" value="{{ isset($row->tanggal_keluar) ? date('d-m-Y', strtotime($row->tanggal_keluar)) : NULL }}" placeholder="Tanggal Keluar"> 
                                        
                                        @error('tanggal_keluar')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ $row->jabatan }}" placeholder="Jabatan"> 
                                        
                                        @error('jabatan')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ $row->alamat }}</textarea>
                                
                                @error('alamat')
                                <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card stacked-form">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="pelajaran">Mata Pelajaran<span class="text-danger">*</span></label>
                                        <select name="pelajaran[]" id="pelajaran" class="form-control selectpicker @error('pelajaran') is-invalid @enderror" multiple data-title="Pilih Pelajaran" data-style="btn-warning btn-fill btn-block" data-menu-style="dropdown-blue">
                                            @foreach ($pelajarans as $pelajaran)
                                            <option value="{{ $pelajaran->id }}" {{ strlen(array_search($pelajaran->id, $guruPelajarans)) > 0 ? 'selected' : '' }}> {{ $pelajaran->nama }} </option>
                                            @endforeach
                                        </select>
                                        
                                        @error('pelajaran')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card stacked-form">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="username">Username<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username_sch }}" placeholder="Username" disabled> 
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password"> 
                                        
                                        @error('password')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-check"></i> Simpan
                                    </button>
                                </div>
                            </div>
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