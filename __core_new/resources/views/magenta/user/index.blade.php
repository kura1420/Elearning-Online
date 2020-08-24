@extends('layouts.app')

@section('titlePage') User @endsection

@section('addTitle') | User @endsection

@section('addCss')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{{$dataTable->scripts()}}
<script>
$(function () {
    $('#sidebarMasterData').addClass('show');
    $('#sidebarUser').addClass('active');
    
    $('[data-toggle="tooltip"]').tooltip();
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
                            {{ $dataTable->table(['class' => 'table table-striped table-no-bordered table-hover', 'style' => 'width:100%'], true) }}
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