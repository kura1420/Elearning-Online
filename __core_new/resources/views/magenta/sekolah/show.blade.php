@extends('layouts.app')

@section('titlePage') Sekolah @endsection

@section('addTitle') | Sekolah @endsection

@section('addCss')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/fancybox/dist/jquery.fancybox.min.css') }}">
@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/fancybox/dist/jquery.fancybox.min.js') }}"></script>
<script>
$(function () {
    $('#sidebarMasterData').addClass('show');
    $('#sidebarSekolah').addClass('active');
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
                            Lihat Data
                            <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nama">Nama Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" disabled placeholder="Nama Sekolah" autofocus value="{{ $row->nama }}">
                                        <input type="hidden" name="id" id="id" value="{{ $row->id }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="singkatan">Singkatan <span class="text-danger">*</span></label>
                                        <input type="text" name="singkatan" id="singkatan" class="form-control" disabled placeholder="Singkatan" value="{{ $row->singkatan }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="npsn">NSPN</label>
                                        <input type="text" name="npsn" id="npsn" class="form-control" disabled placeholder="NSPN" value="{{ $row->npsn }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" disabled>
                                            <option value="">- Pilih -</option>
                                            <option value="swasta" {{ $row->status == 'swasta' ? 'selected' : '' }}>Swasta</option>
                                            <option value="negeri" {{ $row->status == 'negeri' ? 'selected' : '' }}>Negeri</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                                        <select name="pendidikan" id="pendidikan" class="form-control" disabled>
                                            <option value="">- Pilih -</option>
                                            <option value="sd" {{ $row->pendidikan == 'sd' ? 'selected' : '' }}>SD</option>
                                            <option value="smp" {{ $row->pendidikan == 'smp' ? 'selected' : '' }}>SMP</option>
                                            <option value="sma" {{ $row->pendidikan == 'sma' ? 'selected' : '' }}>SMA</option>
                                            <option value="smk" {{ $row->pendidikan == 'smk' ? 'selected' : '' }}>SMK</option>
                                            <option value="universitas" {{ $row->pendidikan == 'universitas' ? 'selected' : '' }}>Universitas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telp">Telp.</label>
                                        <input type="text" name="telp" id="telp" class="form-control" disabled placeholder="Telp." value="{{ $row->telp }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="fax">Fax</label>
                                    <input type="text" name="fax" id="fax" class="form-control" disabled placeholder="Fax" value="{{ $row->fax }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" disabled placeholder="Email" value="{{ $row->email }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" disabled placeholder="Alamat" value="{{ $row->alamat }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="logo">Logo</label> <br>
                                    @if (isset($row->logo))
                                    <a href="{{ asset('uploads/sekolah/logo/' . $row->logo) }}" data-fancybox data-caption="Logo Sekolah">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            <i class="fa fa-image"></i> Priview
                                        </button>
                                    </a>
                                    @else
                                    Logo Tidak Tersedia
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            PIC
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Handphone</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
                                </tr>
                            </thead>
                            <tbody id="tableListPic">
                                @foreach ($pic_sekolahs as $ps)
                                <tr>
                                    <td>{{ $ps->nama }}</td>
                                    <td>{{ $ps->email }}</td>
                                    <td>{{ $ps->handphone }}</td>
                                    <td>{{ $ps->telp }}</td>
                                    <td>{{ $ps->alamat }}</td>
                                    <td>{{ $ps->jabatan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')
<div class="modal fade" id="modalPic" tabindex="-1" role="dialog" aria-labelledby="modalLabelPIC" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelPIC">Form PIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_nama">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="modal_nama" id="modal_nama" class="form-control" disabled placeholder="Nama">
                            </div>

                            <div class="form-group">
                                <label for="modal_email">Email</label>
                                <input type="email" name="modal_email" id="modal_email" class="form-control" disabled placeholder="Email">
                            </div>

                            <div class="form-group">
                                <label for="modal_handphone">Handphone <span class="text-danger">*</span></label>
                                <input type="text" name="modal_handphone" id="modal_handphone" class="form-control" disabled placeholder="Handphone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_telp">Telp</label>
                                <input type="text" name="modal_telp" id="modal_telp" class="form-control" disabled placeholder="Telp">
                            </div>

                            <div class="form-group">
                                <label for="modal_alamat">Alamat</label>
                                <input type="text" name="modal_alamat" id="modal_alamat" class="form-control" disabled placeholder="Alamat">
                            </div>

                            <div class="form-group">
                                <label for="modal_jabatan">Jabatan</label>
                                <input type="text" name="modal_jabatan" id="modal_jabatan" class="form-control" disabled placeholder="Jabatan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                <button type="button" class="btn btn-sm btn-info" id="btnSavePic"><i class="fa fa-pencil"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection