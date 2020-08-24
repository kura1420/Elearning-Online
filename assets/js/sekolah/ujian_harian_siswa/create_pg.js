'use strict';
var listPertanyaan = [];
var listJawaban = [];
var listRagu = [];
var tipeJawaban = null;

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let alert = $('#alert'),
    waktu = $('#waktu'),
    ujian_harian = $('#ujian_harian'),
    ujian_harian_siswa = $('#ujian_harian_siswa'),
    soal = $('#soal');
    
    let timer = $('#timer'),
    wizards = $('#wizards'),
    modalSoalTerjawab = $('#modalSoalTerjawab'),
    modalInstruksi = $('#modalInstruksi'),
    listPertanyaanTerjawab = $('#listPertanyaanTerjawab'),
    btnInstruksi = $('#btnInstruksi'),
    btnShowAnswer = $('#btnShowAnswer'),
    btnSaveAnswer = $('#btnSaveAnswer'),
    btnFastFinish = $('#btnFastFinish');

    const main = {
        _api: base_url + 'sch/ujian-harian-siswa',
        _run: () => {
            main._pageEvent.apply();
        },
        _pageEvent: () => {
            document.addEventListener('contextmenu', event => event.preventDefault());

            wizards.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true
            });

            $('.steps').hide();

            $('tr').on('click', function () {
                $(this).children('td').children('input').prop('checked', true);

                $('tr').removeClass('selected');
                $(this).toggleClass('selected');

                let jawabanSelected = $(this).children('td').children('input');
                let jawabanName = jawabanSelected.attr('name');
                let jawabanText = jawabanSelected.parent().next().text();                

                if (jawabanName) {
                    let grepIdPertanyaan = jawabanName.substring(8);
                    let grepNomorPertanyaan = $(`#no-${grepIdPertanyaan}`).text();                    

                    if (Object.keys(listJawaban).length > 0) {
                        let grepListJawaban = listJawaban.filter((j) => { return j.jawaban_nomor == grepNomorPertanyaan });

                        if (Object.keys(grepListJawaban).length > 0) {
                            grepListJawaban[0].pertanyaan = grepIdPertanyaan;
                            grepListJawaban[0].jawaban_urutan = jawabanText;
                        } else {
                            listJawaban.push({
                                pertanyaan: grepIdPertanyaan,
                                jawaban_nomor: grepNomorPertanyaan,
                                jawaban_urutan: jawabanText,
                                jawaban_tipe: null,
                            });
                        }
                    } else {
                        listJawaban.push({
                            pertanyaan: grepIdPertanyaan,
                            jawaban_nomor: grepNomorPertanyaan,
                            jawaban_urutan: jawabanText,
                            jawaban_tipe: null,
                        });
                    }
                }
            });

            $('.ragu').on('change', function () {
                let raguId = $(this).attr('id'),
                    raguName = $(this).attr('name'),
                    raguValue = $(this).val();                    

                if (raguValue == 1) {
                    let jawabanRagu = $(`input[name="jawaban_${raguId}"]`).is(':checked');

                    if (jawabanRagu) {
                        listRagu.push({
                            soal_nomor: raguName,
                            soal_pertanyaan_id: raguId,
                        });

                        let grepListJawabanTipe = listJawaban.filter((j) => { return j.pertanyaan == raguId });

                        grepListJawabanTipe[0].jawaban_tipe = raguId;                        
                    } else {
                        swal('Silahkan pilih jawaban terlebih dahulu.');

                        $(this).val(0);
                    }
                } else {
                    if (Object.keys(listRagu).length > 0) {
                        let grepListJawabanUncheck = listJawaban.filter((j) => { return j.pertanyaan == raguId });
                        grepListJawabanUncheck[0].jawaban_tipe = null;                       

                        let grepListRaguChecked = listRagu.filter((r) => { return r.soal_nomor !== raguName });
                        listRagu = grepListRaguChecked;                        
                    }
                }                
            });

            $('a').on('click', function () {
                let href = $(this).attr('href');

                if (href == '#finish') {
                    main._methods.finish();
                }
            });            

            timer.FlipClock(waktu.val() * 60, {
                clockFace: 'MinuteCounter',
                countdown: true,
                callbacks: {
                    interval: function() {
                        var time = this.factory.getTime().time;
        
                        if (time == 60) {
                            swal('Waktu anda tinggal sebentar lagi');
                        }
                        
                        if(time == 2) {
                            swal('Waktu anda sudah habis');        
                            
                            main._methods.store();
                        }                                           
                        
                        if (time == alert.val()) {
                            swal('Jangan lupa simpan jawaban secara berkala.');
                        }             
                        
                        console.log(time, alert.val());
                        
                    }
                }
            });

            btnInstruksi.on('click', function () {
                modalInstruksi.modal('show');
            });

            btnShowAnswer.on('click', function () {              
                listJawaban.sort((a, b) => { return a.jawaban_nomor.replace('.', '') - b.jawaban_nomor.replace('.', ''); });

                listPertanyaanTerjawab.html('');

                let buttonLinkRagu = '-';
                $.each(listJawaban, function (key, val) { 
                    buttonLinkRagu = val.jawaban_tipe !== null ? '<button type="button" class="btn btn-sm btn-success btnRagu" value="'+ val.jawaban_tipe +'">Ke Pertanyaan Ragu</button>' : '<button type="button" class="btn btn-sm btn-info btnRagu" value="'+ val.pertanyaan +'">Ke Pertanyaan</button>';

                    listPertanyaanTerjawab.append(`<tr>
                        <td>${val.jawaban_nomor}</td>
                        <td>${val.jawaban_urutan.replace('.', '')}</td>
                        <td>${buttonLinkRagu}</td>
                    </tr>`);
                });        

                modalSoalTerjawab.modal('show');
            });

            $('body').on('click', '.btnRagu', function () {
                let valueRagu = $(this).val();
        
                if (valueRagu) {            
                    let grepKeyListPertanyaan = listPertanyaan.findIndex((val) => { return val === valueRagu });                    
        
                    wizards.steps("setStep", grepKeyListPertanyaan, valueRagu);
        
                    modalSoalTerjawab.modal('hide');
                }
            });

            btnSaveAnswer.on('click', function () {
                main._methods.saveAnswer();
            });

            btnFastFinish.on('click', function () {
                main._methods.finish();
            });
        },
        _methods: {
            saveAnswer: () => {
                let getJawaban = [];
                $('.jawaban').each(function(key, val) {
                    if ($(this).is(':checked')) {
                        getJawaban.push(val.defaultValue);
                    }
                });

                let data = {
                    ujian_harian: ujian_harian.val(),
                    ujian_harian_siswa: ujian_harian_siswa.val(),
                    soal: soal.val(),
                    tipe: 'pg',

                    list_jawaban: getJawaban,
                    list_ragu: listRagu,
                }                 
        
                $.ajax({
                    type: "POST",
                    url: base_url + 'sch/ujian-harian-jawaban-siswa',
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $.notify({
                            message: 'Jawaban berhasil di simpan',
                            type: 'danger',
                        });
                    },
                    error: function (xhr, status, error) {        
                        if (xhr.status == 422) {
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
            },

            finish: () => {
                swal({
                    title: "Konfirmasi",
                    text: "Apakah anda yakin ingin menyelesaikan ujian ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-info btn-fill",
                    confirmButtonText: "Ya, saya yakin!",
                    cancelButtonClass: "btn btn-danger btn-fill",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false,
                }, function() {
                    main._methods.store();
                });
            },

            store: () => {
                let getJawaban = [];
                $('.jawaban').each(function(key, val) {
                    if ($(this).is(':checked')) {
                        getJawaban.push(val.defaultValue);
                    }
                });

                let data = {
                    ujian_harian: ujian_harian.val(),
                    ujian_harian_siswa: ujian_harian_siswa.val(),
                    soal: soal.val(),
                    tipe: 'pg',

                    list_jawaban: getJawaban,
                    list_ragu: listRagu,
                }                

                $('#_loader_').addClass('is-active');
        
                $.ajax({
                    type: "POST",
                    url: main._api,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('#_loader_').removeClass('is-active');

                        swal("Infomasi!", "Soal ujian telah diselesaikan, terimakasih.", "success");
        
                        window.location.href = main._api + '/' + response.token + '/hasil';
                    },
                    error: function (xhr, status, error) {
                        $('#_loader_').removeClass('is-active');
        
                        if (xhr.status == 422) {
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
            },
        }
    }

    main._run.apply();
});