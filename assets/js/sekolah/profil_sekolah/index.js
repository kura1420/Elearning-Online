'use strict';
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let id = $('#id'),
    npsn = $('#npsn'),
    nama = $('#nama'),
    status = $('#status'),
    pendidikan = $('#pendidikan'),
    logo = $('#logo'),
    alamat = $('#alamat'),
    email = $('#email'),
    telp = $('#telp'),
    fax = $('#fax'),
    singkatan = $('#singkatan');

    let btnSave = $('#btnSave'),
    btnUploadFile = $('#btnUploadFile'),
    btnRemoveFile = $('#btnRemoveFile');
    
    const main = {
        urlModule: base_url + 'sch/profil-sekolah',
        run: () => {
            main.eventPage.apply();
        },
        eventPage: () => {
            $('#sidebarPengaturan').addClass('show');
            $('#sidebarProfilSekolah').addClass('active');

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

                            let json = JSON.parse(this.response);                            

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
                    singkatan: singkatan.val(),
                }

                let _id = id.val();
                
                main.actions.update(data, _id);
            });
        },
        actions: {
            update: (data, id) => {
                $('#_loader_').addClass('is-active');

                $.ajax({
                    type: "PUT",
                    url: main.urlModule + '/' + id,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');

                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        $('#_loader_').removeClass('is-active');

                        if (xhr.status === 422) {
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