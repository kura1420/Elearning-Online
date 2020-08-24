@extends('layouts.app')

@section('titlePage') Soal @endsection

@section('addTitle') | Soal @endsection

@section('addCss')

@endsection

@section('addJs')
<script>
$(function () {
    $('#sidebarData').addClass('show');
    $('#sidebarSoal').addClass('active');
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
                                Pilih
                                <a href="{{ url($url) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ url($url . '/' . $row->id . '/import-pertanyaan') }}" class="btn btn-lg btn-primary">
                                Import
                            </a>

                            <a href="{{ url('sch/pertanyaan/create?soal=' . $row->id) }}" class="btn btn-lg btn-success">
                                Manual
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('addModal')

@endsection