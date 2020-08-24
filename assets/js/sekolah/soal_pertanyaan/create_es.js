$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let soal = $('#soal'),
    tipe = $('#tipe');

    let btnSave = $('#btnSave'),
    nomor = $('#nomor'),
    alertSuccess = $('#alertSuccess');
    
    const main = {
        _api: base_url + 'sch/pertanyaan',
        _run: () => {
            main._pageEvent.apply();
            main._methods.getNomor();
        },
        _pageEvent: () => {
            $('#sidebarData').addClass('show');
            $('#sidebarSoal').addClass('active');

            $('#btnNewWindow').on('click', function () {
                window.open(base_url + 'sch/file-upload', "mywindow","location=1,status=1,scrollbars=1,width=800,height=800");
            });

            tinymce.init({
                selector: '#pertanyaan',
                height: 444,
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
                    soal: soal.val(),
                    tipe: tipe.val(),
                    pertanyaan: tinyMCE.activeEditor.getContent(),
                }

                main._methods.store(data);
            });
        },
        _methods: {
            getNomor: () => {
                let data = {
                    soal: soal.val(),
                }

                $.post(base_url + 'app-svc/nomor-pertanyaan', data,
                    function (data, textStatus, jqXHR) {
                        nomor.text(data);
                    },
                    "json"
                );
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

                        nomor.text(response.no);
                        
                        tinyMCE.activeEditor.setContent('');

                        alertSuccess.fadeIn('show').delay(1500).fadeOut();
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