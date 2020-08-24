@extends('layouts.app')

@section('titlePage') Beranda @endsection

@section('addTitle') | Beranda @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarBeranda').addClass('active');
});
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header ">
                <h4 class="card-title">Beranda</h4>
            </div>
            <div class="card-body table-full-width table-responsive">

            </div>
        </div>
    </div>
</div>
@endsection

@section('addModal')

@endsection