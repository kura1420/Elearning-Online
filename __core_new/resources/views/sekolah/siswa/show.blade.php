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
<script src="{{ asset('assets/js/sekolah/siswa/edit.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card stacked-form">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Lihat Data
                                    <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>

                                    <a href="{{ url($url . '/' . $row->id . '/edit') }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nomor_induk">Nomor Induk</label>
                                            <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ $row->nomor_induk }}" placeholder="Nomor Induk" disabled> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $row->nama }}" placeholder="Nama Siswa" disabled> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" disabled value="{{ $row->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" class="form-control" disabled id="tanggal_lahir" name="tanggal_lahir" value="{{ isset($row->tanggal_lahir) ? date('d-m-Y', strtotime($row->tanggal_lahir)) : NULL }}" placeholder="Tanggal Lahir"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" disabled id="tempat_lahir" name="tempat_lahir" value="{{ $row->tempat_lahir }}" placeholder="Tempat Lahir"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                        
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="handphone">Handphone</label>
                                            <input type="text" class="form-control" disabled id="handphone" name="handphone" value="{{ $row->handphone }}" placeholder="Handphone"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="telp">Telp.</label>
                                            <input type="text" class="form-control" disabled id="telp" name="telp" value="{{ $row->telp }}" placeholder="Telp.">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" disabled id="email" name="email" value="{{ $row->email }}" placeholder="Email"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" disabled placeholder="Alamat">{{ $row->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Jenjang Sekolah</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No.</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Kelas</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa_kelas as $sk)
                                        <tr id="tr-{{ $sk->id }}">
                                            <td> {{ $loop->iteration }}. </td>
                                            <td id="tahun_ajaran-{{ $sk->id }}"> {{ $sk->tahun_ajaran_id }} </td>
                                            <td id="kelas-{{ $sk->id }}"> {{ $sk->kelas_id }} </td>
                                            <td id="keterangan-{{ $sk->id }}"> {{ $sk->keterangan }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card card-outline card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Akses Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" disabled id="username" name="username" value="{{ $row->nomor_induk }}" placeholder="Username" disabled> 
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" disabled id="password" name="password" placeholder="Password"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('addModal')

@endsection