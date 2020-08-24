@extends('layouts.app')

@section('titlePage') Pelajaran @endsection

@section('addTitle') | Pelajaran @endsection

@section('addCss')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection

@section('addJs')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{{$dataTable->scripts()}}
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sidebarData').addClass('show');
    $('#sidebarPelajaran').addClass('active');
    
    $('body').on('click', '.btnRemove', function () {
        let val = $(this).val();

        swal({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa dikembalikan kembali",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-info btn-fill",
            confirmButtonText: "Ya, hapus!",
            cancelButtonClass: "btn btn-danger btn-fill",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }, function() {
            $.ajax({
                type: "DELETE",
                url: base_url + "sch/pelajaran/" + val,
                dataType: "json",
                success: function (response) {
                    swal("Infomasi!", "Data berhasil di hapus.", "success");

                    window.LaravelDataTables["datatables"].ajax.reload();                
                },
                error: function (xhr, status, error) {
                    alert(error);
                }
            });
        });
    });
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
                            {{ $dataTable->table(['class' => '', 'style' => 'width:100%'], true) }}
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