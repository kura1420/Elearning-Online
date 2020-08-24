'use strict';
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let npsn = $('#npsn'),
    nama = $('#nama'),
    status = $('#status'),
    pendidikan = $('#pendidikan'),
    logo = $('#logo'),
    alamat = $('#alamat'),
    email = $('#email'),
    telp = $('#telp'),
    fax = $('#fax');

    let modal_nama = $('#modal_nama'),
    modal_email = $('#modal_email'),
    modal_handphone = $('#modal_handphone'),
    modal_telp = $('#modal_telp'),
    modal_alamat = $('#modal_alamat'),
    modal_jabatan = $('#modal_jabatan');

    let btnSave = $('#btnSave'),
    btnUploadFile = $('#btnUploadFile'),
    btnRemoveFile = $('#btnRemoveFile'),
    btnAddPic = $('#btnAddPic'),
    modalPic = $('#modalPic'),
    btnSavePic = $('#btnSavePic'),
    tableListPic = $('#tableListPic');

    var pic_sekolah = [];
    
    const main = {
        urlModule: base_url + 'mgt/sekolah',
        run: () => {
            main.eventPage.apply();
        },
        eventPage: () => {
            $('#sidebarMasterData').addClass('show');
            $('#sidebarSekolah').addClass('active');

            $('#telp, #modal_handphone').numeric();

            btnUploadFile.on('click', function () {
                let file = document.getElementById('file').files[0];
                if (file) {
                    logo.val('');

                    var xhr = new XMLHttpRequest();

                    (xhr.upload || xhr).addEventListener('progress', function (e) {
                        let done = e.loaded;
                        let total = e.total;
                        let percent = Math.round(done / total * 100);

                        $('#file, #btnUploadFile').attr('disabled', true);

                        $('.progress, .progress-bar').css('width', percent + '%');
                    });

                    xhr.addEventListener('load', function (e) {
                        if (this.status === 200) {
                            btnUploadFile.hide();
                            btnRemoveFile.show();

                            let json = this.response;

                            logo.val(json.filename.replace(/"/g, ''));
                        } else {
                            $('#file, #btnUploadFile').attr('disabled', false);

                            $('.progress, .progress-bar').css('width', 0 + '%');

                            swal(this.response);
                        }                                                
                    });

                    var formData = new FormData();
                    xhr.open('post', base_url + 'app-svc/upload-image', true);
                    formData.append('folder', 'uploads/sekolah/logo');
                    formData.append('file', file);
                    formData.append('_token', $('input[name="_token"]').val());
                    xhr.send(formData);
                } else {
                    swal('Masukkan file terlebih dahulu.');
                }                
            });

            btnRemoveFile.on('click', function () {
                let valLogo = logo.val();

                if (valLogo) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "app-svc/delete-image",
                        data: {
                            folder: 'uploads/sekolah/logo',
                            file: valLogo
                        },
                        dataType: "json",
                        success: function (response) {
                            btnUploadFile.show();
                            btnRemoveFile.hide();
                            
                            logo.val('');
                            $('#file').val('');

                            $('#file, #btnUploadFile').attr('disabled', false);

                            $('.progress, .progress-bar').css('width', 0 + '%');
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 422) {
                                swal("Perhatian !", xhr.responseText);  
                            } else {
                                swal(error);
                            }
                        }
                    });
                } else {
                    swal('Anda belum upload file.');
                }
            });

            btnAddPic.on('click', function () {
                modal_nama.val('');
                modal_email.val('');
                modal_handphone.val('');
                modal_telp.val('');
                modal_alamat.val('');
                modal_jabatan.val('');
                
                modalPic.modal('show');
            });

            btnSavePic.on('click', function () {
                let pic_id = _uuid(),
                pic_nama = modal_nama.val(),
                pic_email = modal_email.val(),
                pic_handphone = modal_handphone.val(),
                pic_telp = modal_telp.val(),
                pic_alamat = modal_alamat.val(),
                pic_jabatan = modal_jabatan.val();

                if (pic_nama !== '' && pic_handphone !== '') {
                    tableListPic.append(`<tr>
                        <td>${pic_nama}</td>
                        <td>${pic_email}</td>
                        <td>${pic_handphone}</td>
                        <td>${pic_telp}</td>
                        <td>${pic_alamat}</td>
                        <td>${pic_jabatan}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger btnRemovePic" value="${pic_id}">
                                <i class="fa fa-eraser"></i> Hapus
                            </button>
                        </td>
                    </tr>`);

                    pic_sekolah.push({
                        id: pic_id,
                        nama: pic_nama,
                        email: pic_email,
                        handphone: pic_handphone,
                        telp: pic_telp,
                        alamat: pic_alamat,
                        jabatan: pic_jabatan,
                        status: 'new'
                    });

                    modalPic.modal('hide');       
                } else {
                    swal('Nama dan No. Handphone tidak boleh kosong.');
                }            
            });

            $('body').on('click', '.btnRemovePic', function () {
                let valRemove = $(this).val();

                let grepUnremove = pic_sekolah.filter((p) => {
                    return p.id !== valRemove;
                });
                
                pic_sekolah = grepUnremove;

                $(this).closest('tr').remove();                
            });

            btnSave.on('click', function () {
                let data = {
                    npsn: npsn.val(),
                    nama: nama.val(),
                    status: status.val(),
                    pendidikan: pendidikan.val(),
                    logo: logo.val(),
                    alamat: alamat.val(),
                    email: email.val(),
                    telp: telp.val(),
                    fax: fax.val(),
                    pic_sekolah: pic_sekolah,
                }
                
                main.actions.store(data);
            });
        },
        actions: {
            store: (data) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "POST",
                    url: main.urlModule,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');

                        window.location.href = main.urlModule;
                    },
                    error: function (xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        if (xhr.status === 422) {
                            // let errors = xhr.responseJSON.errors;            

                            // $.each(data, function(key, val) {
                            //     if (errors[key]) {
                            //         $(`#${key}`).addClass('is-invalid');

                            //         let c = $(`#${key}`).parent().find('.invalid-feedback');
                            //         if (c.length === 0) {
                            //             $(`#${key}`).parent().append(`<div class="invalid-feedback">${errors[key][0]}</div>`);  
                            //         } else {
                            //             c.remove();
                            //             $(`#${key}`).parent().append(`<div class="invalid-feedback">${errors[key][0]}</div>`);  
                            //         }
                            //     } else {
                            //         $(`#${key}`).removeClass('is-invalid');
                            //         $(`#${key}`).parent().find('.invalid-feedback').remove();
                            //     }
                            // });

                            let msg = [];
                            $.each(xhr.responseJSON.errors, function (key, val) {
                                msg.push(val);
                            });

                            swal({
                                title: 'Perhatian !',
                                html: msg.join('<br>')
                            });
                        } else {
                            swal(error);
                        }
                    }
                });
            }
        }
    }    

    main.run.apply();
});