$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sidebarData').addClass('show');
    $('#sidebarSiswa').addClass('active');

    $('.datepicker').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    $('#handphone, #telp').numeric();

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

    $('body').on('click', '.btnEditDetail', function () {
        let val = $(this).val();

        if (val) {
            $('#_loader_').addClass('is-active');

            $('#siswa_kelas_id').val('');
            $('#m_tahun_ajaran').val('');
            $('#m_kelas').val('');
            $('#m_keterangan').val('');

            $.ajax({
                type: "GET",
                url: base_url + "app-svc/siswa-kelas/" + val + "/edit",
                dataType: "json",
                success: function (response) {
                    $('#_loader_').removeClass('is-active');

                    $('#siswa_kelas_id').val(response.id);
                    $('#m_tahun_ajaran').val(response.tahun_ajaran_id);
                    $('#m_kelas').val(response.kelas_id);
                    $('#m_keterangan').val(response.keterangan);

                    $('#modal-detail').modal('show');
                },
                error: function (xhr, status, error) {
                    $('#_loader_').removeClass('is-active');

                    swal(error);
                }
            });
        } else {
            swal('Data tidak ditemukan.');
        }
    });

    $('body').on('click', '.btnDeleteDetail', function () {
        let val = $(this).val();

        if (val) {
            $('#_loader_').addClass('is-active');

            $.ajax({
                type: "DELETE",
                url: base_url + "app-svc/siswa-kelas-destroy/" + val,
                dataType: "json",
                success: function (response) {
                    $('#_loader_').removeClass('is-active');

                    $(`#tr-${val}`).remove();
                },
                error: function (xhr, status, error) {
                    $('#_loader_').removeClass('is-active');

                    swal(error);
                }
            });
        } else {
            swal('Data tidak ditemukan.');
        }
    });

    $('#btnSaveDetail').on('click', function () {
        let siswa_kelas_id = $('#siswa_kelas_id').val();
        let data = {
            tahun_ajaran: $('#m_tahun_ajaran').val(),
            kelas: $('#m_kelas').val(),
            keterangan: $('#m_keterangan').val(),
        }

        $('#_loader_').addClass('is-active');

        $.ajax({
            type: "PUT",
            url: base_url + "app-svc/siswa-kelas-put/" + siswa_kelas_id,
            data: data,
            dataType: "json",
            success: function (response) {
                $('#_loader_').removeClass('is-active');     
                
                let text_tahun_ajaran = $('#m_tahun_ajaran option:selected').text(),
                text_kelas = $('#m_kelas option:selected').text(),
                text_keterangan = $('#m_keterangan').val();

                $(`#tahun_ajaran-${siswa_kelas_id}`).text(text_tahun_ajaran);
                $(`#kelas-${siswa_kelas_id}`).text(text_kelas);
                $(`#keterangan-${siswa_kelas_id}`).text(text_keterangan);

                $('#modal-detail').modal('hide');
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
    });
});