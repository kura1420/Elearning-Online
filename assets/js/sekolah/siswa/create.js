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
            up: "fa fa-chevron-up",k
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
});