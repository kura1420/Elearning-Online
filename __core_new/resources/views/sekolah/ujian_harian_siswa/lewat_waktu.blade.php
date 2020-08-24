@extends('layouts.app')

@section('titlePage') Informasi Ujian @endsection

@section('addTitle') | Informasi Ujian @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarUjian').addClass('show');
    $('#sidebarUjianHarian').addClass('active');
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
                <h4 class="card-title">Waktu ujian telah melewati batas waktu</h4>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-sm btn-warning" onclick="window.history.back()">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection