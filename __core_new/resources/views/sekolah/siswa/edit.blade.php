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
                                            <input type="text" class="form-control @error('nomor_induk') is-invalid @enderror" id="nomor_induk" name="nomor_induk" value="{{ $row->nomor_induk }}" placeholder="Nomor Induk" disabled> 
                                            
                                            @error('nomor_induk')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $row->nama }}" placeholder="Nama Siswa" required autofocus> 
                                            
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
                                            <label for="handphone">Handphone</label>
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
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ $row->alamat }}</textarea>
                                            
                                            @error('alamat')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
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
                                            <th style="width: 150px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa_kelas as $sk)
                                        <tr id="tr-{{ $sk->id }}">
                                            <td> {{ $loop->iteration }}. </td>
                                            <td id="tahun_ajaran-{{ $sk->id }}"> {{ $sk->tahun_ajaran_id }} </td>
                                            <td id="kelas-{{ $sk->id }}"> {{ $sk->kelas_id }} </td>
                                            <td id="keterangan-{{ $sk->id }}"> {{ $sk->keterangan }} </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning btnEditDetail" value="{{ $sk->id }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm btnDeleteDetail" value="{{ $sk->id }}">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </td>
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
                                            <label for="username">Username<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $row->nomor_induk }}" placeholder="Username" disabled> 
                                            
                                            @error('username')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password"> 
                                            
                                            @error('password')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="card card card-outline card-warning">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror">
                                                <option value="">- Pilih -</option>
                                                @foreach ($tahunAjarans as $tahunAjaran)
                                                <option value="{{ $tahunAjaran->id }}" {{ $row->tahun_ajaran_id == $tahunAjaran->id ? 'selected' : '' }}> {{ $tahunAjaran->merge_periode . '/' . ucfirst($tahunAjaran->semester) }} </option>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('addModal')
<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label for="m_tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                    <input type="hidden" name="siswa_kelas_id" id="siswa_kelas_id">
                    <select name="m_tahun_ajaran" id="m_tahun_ajaran" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($tahunAjarans as $tahunAjaran)
                        <option value="{{ $tahunAjaran->id }}"> {{ $tahunAjaran->merge_periode . '/' . ucfirst($tahunAjaran->semester) }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="m_kelas">Kelas<span class="text-danger">*</span></label>
                    <select name="m_kelas" id="m_kelas" class="form-control">
                        <option value="">- Pilih -</option>
                        @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"> {{ $k->nama }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="m_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="m_keterangan" name="m_keterangan" placeholder="Keterangan"> 
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveDetail"><i class="fa fa-check"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection