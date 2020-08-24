$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sidebarUjian').addClass('show');
    $('#sidebarUjianHarian').addClass('active');

    const table = $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            emptyTable: 'Silahkan filter data terlebih dahulu.'
        },
        columns: [
            { 'data': 'kelas_id', visible: false },
            // { 'data': 'judul' },
            { 'data': 'tanggal' },
            { 'data': 'soal_id' },
            { 'data': 'pelajaran_id' },
            { 'data': 'pelajaran_tipe_id' },
            { 
                'data': 'aksi', 
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return buttonAction(row);
                }
            },
        ],
    });

    var buttonAction = function (row) {
        let url = base_url + 'sch/ujian-harian';
        let show = `<a href="${url}/${row.id}" class='btn btn-link text-info' data-toggle='tooltip' data-placement='top' title='Lihat'><i class='fa fa-eye'></i></a>`;
        let edit = `<a href="${url}/${row.id}/edit" class='btn btn-link text-warning' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i></a>`;
        let destroy = `<button type="button" class="btn btn-link text-danger btnRemove" value="${row.id}" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>`;

        return show + ' ' + edit + ' ' + destroy;
    }

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

                    if (xhr.status === 422) {
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

    $('#btnFilter').on('click', function () {
        let jenis_ujian = $('#jenis_ujian').val();
        let tahun_ajaran = $('#tahun_ajaran').val();
        let kelas = $('#kelas').val();

        if (jenis_ujian !== '' && tahun_ajaran !== '' && kelas !== '') {
            $('#_loader_').addClass('is-active');

            $.ajax({
                type: "POST",
                url: base_url + "app-svc/list-ujian-harian",
                data: {
                    tahun_ajaran: tahun_ajaran,
                    kelas: kelas,
                    jenis_ujian: jenis_ujian,
                },
                dataType: "json",
                success: function (response) {
                    $('#_loader_').removeClass('is-active');

                    if (Object.keys(response).length > 0) {
                        table.clear();
                        table.rows.add(response);
                        table.draw();   
                    } else {
                        swal('Data tidak tersedia.');
                    }
                },
                error: function (xhr, status, error) {
                    $('#_loader_').removeClass('is-active');

                    if (xhr.status === 422) {
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
            swal('Silahkan pilih tahun ajaran dan kelas terlebih dahulu.');
        }
    });
    
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
                url: base_url + "sch/ujian-harian/" + val,
                dataType: "json",
                success: function (response) {
                    swal("Infomasi!", "Data berhasil di hapus.", "success");

                    table.ajax.reload();                
                },
                error: function (xhr, status, error) {
                    alert(error);
                }
            });
        });
    });
});