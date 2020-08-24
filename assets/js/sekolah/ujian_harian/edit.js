var listSiswa = [];

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let _id = $('#id'),
    judul = $('#judul'),
    tanggal = $('#tanggal'),
    waktu_mulai = $('#waktu_mulai'),
    waktu_habis = $('#waktu_habis'),
    tampilkan_nilai = $('#tampilkan_nilai'),
    alert_simpan_jawaban = $('#alert_simpan_jawaban'),
    batas_kelulusan = $('#batas_kelulusan'),
    pertanyaan_acak = $('#pertanyaan_acak'),
    soal = $('#soal'),
    pelajaran = $('#pelajaran'),
    pelajaran_tipe = $('#pelajaran_tipe'),
    kelas = $('#kelas'),
    jenis_ujian = $('#jenis_ujian'),
    // rumus_penilaian_ujian = $('#rumus_penilaian_ujian'),
    tahun_ajaran = $('#tahun_ajaran');

    let btnSave = $('#btnSave'),
    btnGetDataSiswa = $('#btnGetDataSiswa'),
    getKelas = $('#getKelas');

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
            { 'data': 'nomor_induk' },
            { 'data': 'nama' },
            { 
                'data': 'aksi', 
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {                   
                    if (row.id !== undefined) {
                        return buttonAction(row);    
                    } else {
                        return `<button type="button" class="btn btn-danger btn-sm btnRemove" value="${data}" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> Hapus</button>`;                          
                    }
                }
            },
        ],
    });

    var buttonAction = function (row) {
        let destroy = `<button type="button" class="btn btn-danger btn-sm btnRemove" value="${row.id}" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> Hapus</button>`;

        return destroy;
    }

    const main = {
        _api: base_url + 'sch/ujian-harian',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarUjian').addClass('show');
            $('#sidebarUjianHarian').addClass('active');

            alert_simpan_jawaban.numeric();
            batas_kelulusan.numeric();

            $('#waktu_mulai, #waktu_habis').clockpicker();

            tanggal.datetimepicker({
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

            tampilkan_nilai.on('change', function () {
                let tampilkan_nilai_val = $(this).val();

                if (tampilkan_nilai_val == 1) {
                    batas_kelulusan.attr('disabled', false).val('');
                } else {
                    batas_kelulusan.attr('disabled', true).val('');
                }
            });

            tahun_ajaran.on('change', function() {
                let val = $(this).val();
        
                $('#kelas, #pelajaran, #pelajaran_tipe, #soal').html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addKelas(val);
                } else {
                    swal('Silahkan pilih tahun ajaran terlebih dahulu.');
                }
            });

            kelas.on('change', function () {
                let val = $(this).val();
        
                $('#pelajaran, #pelajaran_tipe, #soal').html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addPelajaran(val);
                } else {
                    swal('Silahkan pilih tahun ajaran dan kelas terlebih dahulu.');
                }
            });

            pelajaran.on('change', function () {
                let val = $(this).val();
        
                $('#pelajaran_tipe, #soal').html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addPelajaranTipe(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas dan pelajaran terlebih dahulu.');
                }
            });

            pelajaran_tipe.on('change', function () {
                let val = $(this).val();

                $('#soal').html('<option value="">- Pilih -</option>');

                if (val) {
                    main._methods.addSoal(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran dan tipe pelajaran terlebih dahulu.')
                }
            });

            btnGetDataSiswa.on('click', function () {
                if (tahun_ajaran.val() !== '' && kelas.val() !== '') {
                    main._methods.addListSiswa(tahun_ajaran.val(), kelas.val());
                } else {
                    swal('Silahkan pilih tahun ajaran dan kelas terlebih dahulu.');
                }
            });

            $('body').on('click', '.btnRemove', function () {
                let val = $(this).val();

                let grepUnremoveListSiswa = listSiswa.filter((s) => { return s.siswa !== val });
                
                listSiswa = grepUnremoveListSiswa;                
        
                table
                    .row( $(`button[value="${val}"]`).parents('tr') )
                    .remove()
                    .draw();

                $.ajax({
                    type: "DELETE",
                    url: base_url + "sch/ujian-harian-siswa/" + val,
                    dataType: "json",
                    success: function (response) {

                    },
                    error: function (xhr, status, error) {        
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

            btnSave.on('click', function () {
                let data = {
                    judul: judul.val(),
                    tanggal: tanggal.val(),
                    waktu_mulai: waktu_mulai.val(),
                    waktu_habis: waktu_habis.val(),
                    tampilkan_nilai: tampilkan_nilai.val(),
                    alert_simpan_jawaban: alert_simpan_jawaban.val(),
                    batas_kelulusan: batas_kelulusan.val(),
                    pertanyaan_acak: pertanyaan_acak.val(),
                    soal: soal.val(),
                    pelajaran: pelajaran.val(),
                    pelajaran_tipe: pelajaran_tipe.val(),
                    kelas: kelas.val(),
                    jenis_ujian: jenis_ujian.val(),
                    // rumus_penilaian_ujian: rumus_penilaian_ujian.val(),
                    tahun_ajaran: tahun_ajaran.val(),

                    list_siswa_ujian: listSiswa,
                }
                
                main._methods.update(data, _id.val());
                
            });
        },
        _methods: {
            addKelas: (val) => {
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
                                kelas.append(`<option value="${val.kelas_id}">${val.nama}</option>`);
                            });
                        } else {
                            swal('Mata Pelajaran tidak tersedia.');
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
            },

            addPelajaran: (val) => {
                $('#_loader_').addClass('is-active');                
    
                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/list-pelajaran",
                    data: {
                        tahun_ajaran: tahun_ajaran.val(),
                        kelas: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
    
                        if (Object.keys(response).length > 0) {
                            $.each(response, function (key, val) { 
                                pelajaran.append(`<option value="${val.pelajaran_id}">${val.nama}</option>`);
                            });

                            let kelasText = $('#kelas option:selected').text();
                            getKelas.val(kelasText);
                        } else {
                            swal('Mata Pelajaran tidak tersedia.');
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
            },

            addPelajaranTipe: (val) => {
                $('#_loader_').addClass('is-active');
    
                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/list-pelajaran-tipe",
                    data: {
                        tahun_ajaran: tahun_ajaran.val(),
                        kelas: kelas.val(),
                        pelajaran: val,
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
    
                        if (Object.keys(response).length > 0) {
                            $.each(response, function (key, val) { 
                                pelajaran_tipe.append(`<option value="${val.id}">${val.nama}</option>`);                            
                            });
                        } else {
                            swal('Pelajaran Tipe tidak tersedia.');
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
            },

            addSoal: (val) => {
                $('#_loader_').addClass('is-active');
    
                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/list-soal",
                    data: {
                        tahun_ajaran: tahun_ajaran.val(),
                        kelas: kelas.val(),
                        pelajaran: pelajaran.val(),
                        pelajaran_tipe: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
    
                        if (Object.keys(response).length > 0) {
                            $.each(response, function (key, val) { 
                                soal.append(`<option value="${val.id}">${val.judul}</option>`);                            
                            });
                        } else {
                            swal('Soal tidak tersedia.');
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
            },

            addListSiswa: (tahun_ajaran, kelas) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/list-siswa",
                    data: {
                        tahun_ajaran: tahun_ajaran,
                        kelas: kelas
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');

                        if (Object.keys(response).length > 0) {
                            table.clear();
                            table.rows.add(response);
                            table.draw();

                            if (Object.keys(listSiswa).length > 0) {
                                listSiswa = [];
                            }

                            response.forEach(el => {
                                listSiswa.push({
                                    siswa: el.id
                                });                                
                            });
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
            },

            update: (data, _id) => {
                $('#_loader_').addClass('is-active');
        
                $.ajax({
                    type: "PUT",
                    url: main._api + '/' + _id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
        
                        window.location.href = main._api;
                    },
                    error: function (xhr, status, error) {
                        $('#_loader_').removeClass('is-active');
        
                        if (xhr.status === 422) {
                            let msg = [];
                            $.each(xhr.responseJSON.errors, function (key, val) {
                                msg.push(val);
                            });
        
                            swal({
                                title: 'Peringatan',
                                html: msg.join('<br>'),
                            });
                        } else {
                            swal(error);
                        }
                    }
                });
            }
        }
    }

    main._run.apply();
});