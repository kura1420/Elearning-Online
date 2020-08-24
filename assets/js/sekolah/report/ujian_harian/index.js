$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
            { 'data': 'kelas' },
            { 'data': 'total_pertanyaan' },
            { 'data': 'nilai' },
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
        let url = base_url + 'sch/report/ujian-harian';
        let show = `<div class="btn-group btn-sm" role="group" aria-label="Button group with nested dropdown">
            <a href="${url}/${row.id}/hasil" target="_blank" class="btn btn-secondary">Lihat</a>
        
            <div class="btn-group" role="group">
                <button id="btnGroupPdf" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    PDF
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupPdf">
                    <a class="dropdown-item" href="${url}/export/${row.id}/pdf" target="_blank">Soal & Jawaban</a>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button id="btnGroupExcel" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Excel
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupExcel">
                    <a class="dropdown-item" href="${url}/export/${row.id}/excel" target="_blank">Soal & Jawaban</a>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button id="btnGroupWord" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Word
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupWord">
                    <a class="dropdown-item" href="${url}/export/${row.id}/word" target="_blank">Soal & Jawaban</a>
                </div>
            </div>
        </div>`;

        return show;
    }

    let tahun_ajaran = $('#tahun_ajaran'),
    kelas = $('#kelas'),
    pelajaran = $('#pelajaran'),
    pelajaran_tipe = $('#pelajaran_tipe'),
    soal = $('#soal'),
    jenis_ujian = $('#jenis_ujian'),
    tanggal_ujian = $('#tanggal_ujian'),
    btnFilter = $('#btnFilter'),
    btnExportSummary = $('#btnExportSummary');

    const main = {
        _api: 'sch/report/ujian-harian',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarReport').addClass('show');
            $('#sidebarReportHarian').addClass('active');

            btnExportSummary.attr('href', '#');

            tahun_ajaran.on('change', function() {
                let val = $(this).val();
        
                $('#kelas, #pelajaran, #pelajaran_tipe, #soal, #tanggal_ujian').html('<option value="">- Pilih -</option>');

                jenis_ujian.val('');
        
                if (val) {
                    main._methods.addKelas(val);
                } else {
                    swal('Silahkan pilih tahun ajaran terlebih dahulu.');
                }
            });

            kelas.on('change', function () {
                let val = $(this).val();
        
                $('#pelajaran, #pelajaran_tipe, #soal, #tanggal_ujian').html('<option value="">- Pilih -</option>');

                jenis_ujian.val('');
        
                if (val) {
                    main._methods.addPelajaran(val);
                } else {
                    swal('Silahkan pilih tahun ajaran dan kelas terlebih dahulu.');
                }
            });

            pelajaran.on('change', function () {
                let val = $(this).val();
        
                $('#pelajaran_tipe, #soal, #tanggal_ujian').html('<option value="">- Pilih -</option>');

                jenis_ujian.val('');
        
                if (val) {
                    main._methods.addPelajaranTipe(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas dan pelajaran terlebih dahulu.');
                }
            });

            pelajaran_tipe.on('change', function () {
                let val = $(this).val();

                $('#soal, #tanggal_ujian').html('<option value="">- Pilih -</option>');

                jenis_ujian.val('');

                if (val) {
                    main._methods.addSoal(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran dan tipe pelajaran terlebih dahulu.')
                }
            });

            jenis_ujian.on('change', function () {
                let val = $(this).val();

                $('#tanggal_ujian').html('<option value="">- Pilih -</option>');

                if (val) {
                    main._methods.addTanggalUjian(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran, tipe pelajaran dan soal terlebih dahulu.')
                }
            });

            btnFilter.on('click', function () {
                main._methods.filterData();
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

            addTanggalUjian: (val) => {
                $('#_loader_').addClass('is-active');
    
                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/tgl-ujian-harian",
                    data: {
                        tahun_ajaran: tahun_ajaran.val(),
                        kelas: kelas.val(),
                        pelajaran: pelajaran.val(),
                        pelajaran_tipe: pelajaran_tipe.val(),
                        soal: soal.val(),
                        jenis_ujian: val,
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');     
    
                        if (Object.keys(response).length > 0) {
                            $.each(response, function (key, val) { 
                                tanggal_ujian.append(`<option value="${val.id}">${val.tanggal_waktu_ujian}</option>`);                            
                            });
                        } else {
                            swal('Tanggal Ujian tidak tersedia.');
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

            filterData: () => {
                $('#_loader_').addClass('is-active');

                let data = {
                    soal: soal.val(),
                    pelajaran: pelajaran.val(),
                    pelajaran_tipe: pelajaran_tipe.val(),
                    kelas: kelas.val(),
                    tanggal_ujian: tanggal_ujian.val(),
                }

                $.ajax({
                    type: "POST",
                    url: base_url + main._api + '/filter',
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
                        
                        if (Object.keys(response).length > 0) {
                            table.clear();
                            table.rows.add(response);
                            table.draw();   

                            btnExportSummary.attr('href', 'ujian-harian/export/' + tanggal_ujian.val() + '/excel/summary');
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

        }
    }

    main._run.apply();
});