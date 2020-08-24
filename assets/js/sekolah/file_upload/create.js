$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sidebarData').addClass('show');
    $('#sidebarFileUpload').addClass('active');

    $('#random_nama').on('change', function () {
        let valRandomNama = $(this).val();        

        if (valRandomNama == 1) {
            $('#nama').attr('disabled', true).val('');
        } else {
            $('#nama').attr('disabled', false).val('');
        }
    });

    $('#file').on('change', function() {
        var id = $(this).attr('id');
        var getFile = document.getElementById(id);
        var file = getFile.files[0];

        if ($('#tipe').val() !== '' && $('#folder').val() !== '') {
            if (file !== undefined) {
                $('#url').val('');
                $('#progress-header, #progress-child').css('width', 0 + '%');
    
                var xhr = new XMLHttpRequest();
                (xhr.upload || xhr).addEventListener('progress', function(e) {
                    var done = e.loaded;
                    var total = e.total;
                    var percent = Math.round(done / total * 100);
    
                    $('#progress-header, #progress-child').css('width', percent + '%');
                });
    
                xhr.addEventListener('load', function(e) {
                    var resp = JSON.parse(this.responseText);
    
                    if (resp.errors) {
                        let msg = [];
                        $.each(resp.errors, function (key, val) {
                            msg.push(val);
                        });
    
                        swal({ title: 'Peringatan', html: msg.join('<br>'), });
    
                        $('#progress-header, #progress-child').css('width', 0 + '%');
                    } else {
                        $('#nama').val('');
                        $('#tipe').val('');
                        $('#folder').val('');
                        $('#file').val('');
                        $('#progress-header, #progress-child').css('width', 0 + '%');
    
                        $('#url').val(resp);
    
                        swal('Upload file berhasil, silahkan copy URL FILE ke pertanyaan atau jawaban.');
                    }
                });
    
                var postData = new FormData();
                xhr.open('post', base_url + 'sch/file-upload', true);
                postData.append('file', file);
                postData.append('random_nama', $('#random_nama').val());
                postData.append('nama', $('#nama').val());
                postData.append('tipe', $('#tipe').val());
                postData.append('folder', $('#folder').val());
                postData.append('_token', $('input[name="_token"]').val());
                xhr.send(postData);
            } else {
                swal('File tidak ditemukan.');
            }
        } else {
            swal('Silahkan pilih tipe dan folder terlebih dahulu.');

            $('#file').val('');
        }
    });
});