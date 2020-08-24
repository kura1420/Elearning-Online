var listPertanyaan = [];

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let _id = $('#id'),
    judul = $('#judul'),
    instruksi = $('#instruksi'),
    tipe = $('#tipe'),
    tipe_pilihan_ganda = $('#tipe_pilihan_ganda'),
    rumus_penilaian_ujian = $('#rumus_penilaian_ujian'),
    publish = $('#publish'),
    mata_pelajaran = $('#mata_pelajaran'),
    pelajaran_tipe = $('#pelajaran_tipe'),
    kelas = $('#kelas'),
    tahun_ajaran = $('#tahun_ajaran');

    let btnSave = $('#btnSave');

    const main = {
        _api: base_url + 'sch/soal',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarData').addClass('show');
            $('#sidebarSoal').addClass('active');

            tinymce.init({
                selector: '#instruksi',
                height: 300,
            });

            tahun_ajaran.on('change', function() {
                let val = $(this).val();
        
                $('#mata_pelajaran, #kelas').html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addKelas(val);
                } else {
                    swal('Silahkan pilih tahun ajaran terlebih dahulu.');
                }
            });

            kelas.on('change', function () {
                let val = $(this).val();
        
                mata_pelajaran.html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addMataPelajaran(val);
                } else {
                    swal('Silahkan pilih tahun ajaran dan kelas terlebih dahulu.');
                }
            });

            mata_pelajaran.on('change', function () {
                let val = $(this).val();
        
                pelajaran_tipe.html('<option value="">- Pilih -</option>');
        
                if (val) {
                    main._methods.addPelajaranTipe(val);
                } else {
                    swal('Silahkan pilih tahun ajaran, kelas dan pelajaran terlebih dahulu.');
                }
            });

            tipe.on('change', function () {
                let val = $(this).val();

                if (val === 'pg') {
                    tipe_pilihan_ganda.attr('disabled', false).val('');
                } else {
                    tipe_pilihan_ganda.attr('disabled', true).val('');
                }
            });

            $('body').on('click', '.btnRemove', function () {
                let val = $(this).val();
        
                if (Object.keys(listPertanyaan).length > 0) {
                    let grepUnremoveListPertanyaan = listPertanyaan.filter((p) => { return p !== val; });
        
                    listPertanyaan = grepUnremoveListPertanyaan;                    
        
                    $(`.${val}`).remove();
                }
            });

            btnSave.on('click', function() {
                let data = {
                    judul: judul.val(),
                    instruksi: tinyMCE.activeEditor.getContent(),
                    tipe: tipe.val(),
                    tipe_pilihan_ganda: tipe_pilihan_ganda.val(),
                    rumus_penilaian_ujian: rumus_penilaian_ujian.val(),
                    publish: publish.val(),
                    mata_pelajaran: mata_pelajaran.val(),
                    pelajaran_tipe: pelajaran_tipe.val(),
                    kelas: kelas.val(),
                    tahun_ajaran: tahun_ajaran.val(),

                    list_pertanyaan: listPertanyaan,
                }

                main._methods.copyData(data, _id.val());
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

            addMataPelajaran: (val) => {
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
                                mata_pelajaran.append(`<option value="${val.pelajaran_id}">${val.nama}</option>`);
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

            copyData: (data, _id) => {
                $('#_loader_').addClass('is-active');                
                
                $.ajax({
                    type: "POST",
                    url: main._api + '/' + _id + '/copy',
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');
                        
                        window.location.href = main._api + '/' + response.url;
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
            }
        }
    }

    main._run.apply();
});