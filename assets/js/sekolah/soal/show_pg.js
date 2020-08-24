$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let soal_id = $('#soal_id'),
    tahun_ajaran = $('#tahun_ajaran'),
    kelas = $('#kelas'),
    pelajaran = $('#pelajaran'),
    pelajaran_tipe = $('#pelajaran_tipe'),
    soal = $('#soal');

    let btnCopyPertanyaan = $('#btnCopyPertanyaan'),
    modalCopyPertanyaan = $('#modalCopyPertanyaan'),
    btnLoadPertanyaan = $('#btnLoadPertanyaan'),
    btnCopyPertanyaanCheck = $('#btnCopyPertanyaanCheck');

    var listPertanyaan = [],
        listTable = [];

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
            { 'data': 'nomor' },
            { 'data': 'pertanyaan' },
            { 
                'data': 'tipe', 
                render: function (data, type, row, meta)  {
                    return checkTipe(row);
                }
            },
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

    var checkTipe = function (row) {
        var status = null;
        switch (row.tipe) {
            case 'pg':
                status = 'Pilihan Ganda';
                break;

            case 'es':
                status = 'Essay';
                break;

            case 'cu':
                status = 'Custom';
                break;
        
            default:
                status = 'No Defined';
                break;
        }

        return status;
    }

    var buttonAction = function (row) {
        let priview = `<button type="button" class="btn btn-sm btn-info btnPriviewSoalPertanyaan" value="${row.id}">
            <i class="fa fa-eye"></i> Priview
        </button>`;

        let destroy = `<button type="button" class="btn btn-danger btn-sm btnRemoveListTable" value="${row.id}"><i class="fa fa-trash"></i> Hapus</button>`;

        return priview + ' ' + destroy;
    }

    const main = {
        _api: base_url + 'sch/soal',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarData').addClass('show');
            $('#sidebarSoal').addClass('active');
            
            $('[data-toggle="tooltip"]').tooltip();

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
                        url: base_url + "sch/pertanyaan/" + val,
                        dataType: "json",
                        success: function (response) {
                            swal("Infomasi!", "Data berhasil di hapus.", "success");
        
                            $(`.${val}`).remove();
                        },
                        error: function (xhr, status, error) {
                            alert(error);
                        }
                    });
                });
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
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran dan tipe pelajaran terlebih dahulu.');
                }
            });

            $('body').on('click', '.btnPriviewSoalPertanyaan', function () {
                let val = $(this).val();

                window.open(base_url + 'sch/pertanyaan/' + val, "mywindow","location=1,status=1,scrollbars=1,width=800,height=800");
            });

            btnCopyPertanyaan.on('click', function () {
                main._methods.resetFormCopyPertanyaan();

                modalCopyPertanyaan.modal('show');
            });

            btnLoadPertanyaan.on('click', function () {
                let valSoal = soal.val();

                if (tahun_ajaran.val() !== '' && kelas.val() !== '' && pelajaran.val() !== '' && pelajaran_tipe.val() !== '' && valSoal !== '') {
                    main._methods.loadSoalPertanyaan(valSoal);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran, tipe pelajaran dan soal terlebih dahulu.')
                }
            });

            $('body').on('click', '.btnRemoveListTable', function () {
                let val = $(this).val();

                if (Object.keys(listPertanyaan).length > 0) {
                    let grepUnremoveListPertanyaan = listPertanyaan.filter((p) => { return p !== val; });
        
                    listPertanyaan = grepUnremoveListPertanyaan;            
        
                    $(`button[value="${val}"]`).closest('tr').remove();
                }
            });

            btnCopyPertanyaanCheck.on('click', function () {
                if (tahun_ajaran.val() !== '' && kelas.val() !== '' && pelajaran.val() !== '' && pelajaran_tipe.val() !== '' && soal.val() !== '') {
                    let data = {
                        soal: soal.val(),
                        list_pertanyaan: listPertanyaan,
                    }

                    main._methods.copyPertanyaanCheck(data, soal_id.val());
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas, pelajaran, tipe pelajaran dan soal terlebih dahulu.')
                }
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

            loadSoalPertanyaan: (val) => {
                $('#_loader_').addClass('is-active');

                listPertanyaan = [];
                listTable = [];

                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/list-soal-pertanyaan",
                    data: { soal: val },
                    dataType: "json",
                    success: function(response) {
                        $('#_loader_').removeClass('is-active');                        

                        if (response.recordsTotal !== 0) {
                            $.each(response.data, function (key, val) { 
                                listTable.push({
                                    'id': val.id,
                                    'nomor': val.nomor,
                                    'pertanyaan': main._methods.convertHTMLToString(val.pertanyaan),
                                    'tipe': val.tipe,
                                });

                                listPertanyaan.push(val.id);
                            });                            

                            table.clear();
                            table.rows.add(listTable);
                            table.draw();
                        } else {
                            swal('Data tidak tersedia.');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        if (xhr.status === 422) {
                            let msg = [];
                            $.each(xhr.responseJSON.errors, function(key, val) {
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
            },

            resetFormCopyPertanyaan: () => {
                tahun_ajaran.val('');
                kelas.val('');
                pelajaran.val('');
                soal.val('');

                table.clear();
                table.draw();
            },

            convertHTMLToString: (html) => {
                var tag = document.createElement('div');
                tag.innerHTML = html;
                
                return tag.innerText;
            },

            copyPertanyaanCheck: (data, soal_id) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "POST",
                    url: main._api + '/' + soal_id + '/copy-pertanyaan-check',
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#_loader_').removeClass('is-active');            
                        
                        swal({
                            title: "Apakah anda yakin?",
                            text: response.msg,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn btn-info btn-fill",
                            confirmButtonText: "Ya, copy",
                            cancelButtonClass: "btn btn-danger btn-fill",
                            cancelButtonText: "Batal",
                            closeOnConfirm: false,
                        }, function() {
                            main._methods.copyPertanyaanProcess(data, soal_id);
                        });
                    },
                    error: function(xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        if (xhr.status === 422) {
                            let msg = [];
                            $.each(xhr.responseJSON.errors, function(key, val) {
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
            },

            copyPertanyaanProcess: (data, soal_id) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "POST",
                    url: main._api + '/' + soal_id + '/copy-pertanyaan-process',
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#_loader_').removeClass('is-active');            
                        
                        swal("Infomasi!", "Data pertanyaan berhasil di copy.", "success");

                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        if (xhr.status === 422) {
                            let msg = [];
                            $.each(xhr.responseJSON.errors, function(key, val) {
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