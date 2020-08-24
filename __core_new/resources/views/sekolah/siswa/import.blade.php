@extends('layouts.app')

@section('titlePage') Siswa @endsection

@section('addTitle') | Siswa @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sidebarData').addClass('show');
    $('#sidebarSiswa').addClass('active');

    $('#tahun_ajaran').on('change', function () {
        let val = $(this).val();

        $('#kelas').html('<option value="">- Pilih Kelas -</option>');
        if (val) {
            $('#_loader_').addClass('is-active');

            $.ajax({
                type: "POST",
                url: base_url + "app-svc/list-kelas",
                data: { ta: val },
                dataType: "json",
                success: function (response) {
                    $('#_loader_').removeClass('is-active');

                    if (Object.keys(response).length > 0) {
                        $.each(response, function (key, val) { 
                             $('#kelas').append(`<option value="${val.kelas_id}">${val.nama}</option>`);
                        });
                    } else {
                        swal('Data tidak tersedia');
                    }
                },
                error: function (xhr, status, error) {
                    $('#_loader_').removeClass('is-active');

                    if (xhr.status == 422) {
                        let msg = [];
                        $.each(xhr.responseJSON.errors, function (key, val) {
                            msg.push(val);
                        });
    
                        swal({ title: 'Peringatan', html: msg.join('<br>'), });
                    } else {
                        swal(error);
                    }
                }
            });
        } else {
            swal('Silahkan pilih tahun ajaran terlebih dahulu.');
        }
    });

    $('#btnSubmit').on('click', function () {
        $('#_loader_').addClass('is-active');
    });
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
                                Import Data
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url($url . '/import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
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
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="kelas">Kelas<span class="text-danger">*</span></label>
                                            <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                                <option value="">- Pilih -</option>
                                            </select>
                                            
                                            @error('kelas')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="file">{{ __('Import Profile Siswa') }} <span class="text-danger">*</span></label>
                                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}" placeholder="Import Profile Siswa">

                                            @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary" id="btnSubmit">
                                        <i class="fa fa-check"></i> Simpan
                                    </button>

                                    <a href="{{ asset('template/siswa.xlsx') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-download"></i> Download Template Import
                                    </a>
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