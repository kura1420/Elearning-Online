$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let periode_awal = $('#periode_awal'),
    periode_akhir = $('#periode_akhir'),
    semester = $('#semester'),
    btnSave = $('#btnSave');
    
    var jadwal = [];

    const main = {
        _api: base_url + 'sch/tahun-ajaran',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarData').addClass('show');
            $('#sidebarTahunAjaran').addClass('active');

            $('body').on('change', '.selectMataPelajaran', function() {
                let id = $(this).attr('id'),
                    val = $(this).val();
        
                $(`#guru_${id}`).html('<option value="">- Pilih -</option>');
                    
                if (val) {
                    main._methods.addListGuru(val, id);
                } else {
                    swal('Silahkan mata pelajaran terlebih dahulu');
                }
            });
        
            $('body').on('click', '.btnAddMataPelajaran', function() {
                let valKelas = $(this).val(),
                    valMataPelajaran = $(`#${valKelas}`).val(),
                    valGuru = $(`#guru_${valKelas}`).val();
        
                let textMataPelajaran = $(`#${valKelas} option:selected`).text(),
                    textGuru = $(`#guru_${valKelas} option:selected`).text();
                
                if (valMataPelajaran !== '' && valGuru !== '') {
                    main._methods.addGuruPelajaran(valKelas, valMataPelajaran, valGuru, textMataPelajaran, textGuru);
                } else {
                    swal('Data mata pelajaran dan guru tidak boleh kosong');
                }
            });
        
            $('body').on('click', '.btnDelete', function() {
                let val = $(this).val(),
                    id = $(this).attr('id');
        
                let filterUndeleteJadwal = jadwal.filter(o => o.pelajaran_id !== id && o.kelas_id === val);
        
                jadwal = filterUndeleteJadwal;
                
                $(`#${val}-${id}`).remove();
            });

            btnSave.on('click', function() {
                let data = {
                    periode_awal: periode_awal.val(),
                    periode_akhir: periode_akhir.val(),
                    semester: semester.val(),
                    list_mata_pelajaran_kelas: jadwal
                }

                main._methods.store(data);
            });
        },
        _methods: {
            addListGuru: (val, id) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "POST",
                    url: base_url + "app-svc/guru-pelajaran",
                    data: {
                        mt: val,
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#_loader_').removeClass('is-active');

                        if (Object.keys(response).length > 0) {
                            $.each(response, function(key, val) {
                                $(`#guru_${id}`).append(`<option value="${val.id}"> ${val.nama}`);
                            });
                        } else {
                            swal('Data guru tidak tersedia');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        swal(error);
                    }
                });
            },

            addGuruPelajaran: (valKelas, valMataPelajaran, valGuru, textMataPelajaran, textGuru) => {
                if (Object.keys(jadwal).length > 0) {
                    let filterCheckJadwal = jadwal.filter(o => o.pelajaran_id === valMataPelajaran && o.kelas_id === valKelas);                
    
                    if (Object.keys(filterCheckJadwal).length > 0) {
                        swal('Data mata pelajaran sudah tersedia.');
                    } else {
                        jadwal.push({
                            kelas_id: valKelas,
                            pelajaran_id: valMataPelajaran,
                            user_guru_id: valGuru
                        });
    
                        $(`#table_${valKelas}`).append(`<tr id="${valKelas}-${valMataPelajaran}">
                            <td> ${textMataPelajaran} </td>
                            <td> ${textGuru} </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger btnDelete" id="${valMataPelajaran}" value="${valKelas}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>`);
                    }                
                } else {
                    jadwal.push({
                        kelas_id: valKelas,
                        pelajaran_id: valMataPelajaran,
                        user_guru_id: valGuru
                    });               
    
                    $(`#table_${valKelas}`).append(`<tr id="${valKelas}-${valMataPelajaran}">
                        <td> ${textMataPelajaran} </td>
                        <td> ${textGuru} </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger btnDelete" id="${valMataPelajaran}" value="${valKelas}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>`);
                }
            },

            store: (data) => {
                $('#_loader_').addClass('is-active');
        
                $.ajax({
                    type: "POST",
                    url: main._api,
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