@extends('layouts.app')

@section('titlePage') Ujian Harian Siswa @endsection

@section('addTitle') | Ujian Harian Siswa @endsection

@section('addCss')

@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script>
$(function () {
    $('#sidebarUjian').addClass('show');
    $('#sidebarUjianHarian').addClass('active');

    $('#datatables').dataTable();
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="fresh-datatables">
                            <table id="datatables" class="" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Jenis Ujian</th>
                                        <th>Pelajaran</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Habis</th>
                                        <th style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Jenis Ujian</th>
                                        <th>Pelajaran</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Habis</th>
                                        <th style="width: 150px;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($rows as $row)
                                    <tr>
                                        <td>{{ $row->jenis_ujian }}</td>
                                        <td>{{ $row->pelajaran }}</td>
                                        <td>{{ $row->soal }}</td>
                                        <td>{{ $row->tanggal }}</td>
                                        <td>{{ $row->waktu_mulai }} WIB</td>
                                        <td>{{ $row->waktu_habis }} WIB</td>
                                        <td>
                                            @switch($row->status)
                                                @case('BR')
                                                    <a href="{{ url($url . '/' . $row->ujian_harian_siswa_id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pencil"></i> Mulai
                                                    </a>
                                                    @break

                                                @case('OP')
                                                    <a href="{{ url($url . '/create?h=' . $row->ujian_harian_id . '&s=' . $row->ujian_harian_siswa_id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i> Kembali Ujian
                                                    </a>
                                                    @break

                                                @case('FN')
                                                    Ujian telah diselesaikan
                                                    @break

                                                @default
                                                    No Defined
                                            @endswitch
                                        </td>
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
</div>
@endsection

@section('addModal')

@endsection