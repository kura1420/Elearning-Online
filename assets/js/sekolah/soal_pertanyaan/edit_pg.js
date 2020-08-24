$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let _id = $('#id'),
    kunci_jawaban = $('#kunci_jawaban'),
    tipe_pilihan_ganda = $('#tipe_pilihan_ganda');
    soal = $('#soal');

    let btnSave = $('#btnSave'),
    nomor = $('#nomor'),
    alertSuccess = $('#alertSuccess');
    
    const main = {
        _api: base_url + 'sch/pertanyaan',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            $('#sidebarData').addClass('show');
            $('#sidebarSoal').addClass('active');

            $('#btnNewWindow').on('click', function () {
                window.open(base_url + 'sch/file-upload', "mywindow","location=1,status=1,scrollbars=1,width=800,height=800");
            });

            tinymce.init({
                selector: '#pertanyaan',
                height: 600,
                plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                    'table emoticons template paste help'
                ],
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |' +
                    ' bullist numlist outdent indent | link image | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | help',
                menubar: 'favs file edit view insert format tools table help',

                paste_data_images: true,
                relative_urls: false,
                remove_script_host : false,
                convert_urls : true,
                
                images_upload_handler: function (blobInfo, success, failure) {                   
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', base_url + 'app-svc/upload-image');
                    xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);                        

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(base_url + json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob());
                    formData.append('folder', 'uploads');
                    formData.append('_token', $('input[name="_token"]').val());
                    xhr.send(formData);
                }
            });

            tinymce.init({
                selector: '.jawaban',
                height: 250,
                plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                    'table emoticons template paste help'
                ],
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |' +
                    ' bullist numlist outdent indent | link image | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | help',
                menubar: 'favs file edit view insert format tools table help',

                paste_data_images: true,
                relative_urls: false,
                remove_script_host : false,
                convert_urls : true,
                
                images_upload_handler: function (blobInfo, success, failure) {                   
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', base_url + 'app-svc/upload-image');
                    xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);                        

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(base_url + json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob());
                    formData.append('folder', 'uploads');
                    formData.append('_token', $('input[name="_token"]').val());
                    xhr.send(formData);
                }
            });

            btnSave.on('click', function () {
                let data = {
                    kunci_jawaban: kunci_jawaban.val(),
                    tipe_pilihan_ganda: tipe_pilihan_ganda.val(),
                    pertanyaan: tinyMCE.get('pertanyaan').getContent(),
                    jawaban_a: tinyMCE.get('jawaban_a').getContent(),
                    jawaban_b: tinyMCE.get('jawaban_b').getContent(),
                    jawaban_c: tinyMCE.get('jawaban_c').getContent(),
                    jawaban_d: tinyMCE.get('jawaban_d').getContent(),
                    jawaban_e: tinyMCE.get('jawaban_e').getContent(),
                }

                main._methods.update(data, _id.val());
            });
        },
        _methods: {
            update: (data, _id) => {
                $('#_loader_').addClass('is-active');
                
                $.ajax({
                    type: "PUT",
                    url: main._api + '/' + _id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');

                        window.location.href = base_url + 'sch/soal/' + soal.val();
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