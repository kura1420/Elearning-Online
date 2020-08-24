<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/insert', function () {
    \App\User::create([
        'id' => Str::uuid(),
        'name' => 'Root Application',
        'email' => 'root@domain.com',
        'username' => 'root',
        'password' => bcrypt(123123),
        'level' => 'rot',
        'active' => 1,
        'type' => 'mgt'
    ]);
});

Route::get('/', 'WelcomeController@index')->name('index');

# App. Auth
Route::get('/mgt/login', 'Magenta\LoginController@index');
Route::post('/mgt/login', 'Magenta\LoginController@process');

Route::get('/sch/{sekolah_id}/login', 'Sekolah\LoginController@index');
Route::post('/sch/{sekolah_id}/login', 'Sekolah\LoginController@process');

Route::get('/sch/{sekolah_id}/lupa-password', 'Sekolah\LupaPasswordController@index');
Route::get('/sch/{sekolah_id}/lupa-password/{user_id}/reset', 'Sekolah\LupaPasswordController@reset');
Route::post('/sch/{sekolah_id}/lupa-password', 'Sekolah\LupaPasswordController@check');
Route::put('/sch/{sekolah_id}/lupa-password/{user_id}/reset', 'Sekolah\LupaPasswordController@resetProcess');

Auth::routes(['register' => false]);

# App. Service
Route::group(
    [
        'prefix' => 'app-svc',
    ],
    function () {
        $controller = 'AppServiceController@';

        Route::get('/siswa-kelas/{siswa_kelas_id}/edit', $controller . 'siswaKelasEdit');

            Route::post('/upload-image', $controller . 'uploadImage');
            Route::post('/delete-image', $controller . 'deleteImage');

            Route::post('/guru-pelajaran', $controller . 'guruPelajaran');
            
            Route::post('/tahun-ajaran-jadwal/destroy', $controller . 'tahunAjaranJadwalDestroy');

            Route::post('/list-kelas', $controller . 'listKelas');
            Route::post('/list-siswa', $controller . 'listSiswa');
            Route::post('/list-pelajaran', $controller . 'listPelajaran');
            Route::post('/list-pelajaran-tipe', $controller . 'listPelajaranTipe');
            Route::post('/list-soal', $controller . 'listSoal');
            Route::post('/list-ujian-harian', $controller . 'listUjianHarian');
            Route::post('/list-soal-pertanyaan', $controller . 'listSoalPertanyaan');

            Route::post('/nomor-pertanyaan', $controller . 'nomorPertanyaan');

            Route::post('/tgl-ujian-harian', $controller . 'tglUjianHarian');

                Route::put('/siswa-kelas-put/{siswa_kelas_id}', $controller . 'siswaKelasPut');

                    Route::delete('/siswa-kelas-destroy/{siswa_kelas_id}', $controller . 'siswaKelasDestroy');
    }
);

# Magenta
# https://domain.com/mgt/[module]
Route::group(
    [
        'middleware' => 'auth:web',
        'prefix' => 'mgt',
        'namespace' => 'Magenta',
    ],
    function () {
        Route::get('/', 'BerandaController@index')->name('magenta_beranda');

        # Other Action
        Route::post('/logout', 'LoginController@logout');

        # CRUD
        Route::resource('/pic-sekolah', 'PicSekolahController');
        Route::resource('/sekolah', 'SekolahController');
        Route::resource('/user', 'UserController');
    }
);

# Sekolah
# https://domain.com/sch/[module]
Route::group(
    [
        'middleware' => 'auth:web',
        'prefix' => 'sch',
        'namespace' => 'Sekolah'
    ],
    function () {
        Route::get('/', 'BerandaController@index')->name('sekolah_beranda');


        # Other Action
        Route::get('/file-upload', 'FileUploadController@index');
        Route::get('/file-upload/create', 'FileUploadController@create');
            Route::post('/file-upload', 'FileUploadController@store');
                Route::delete('/file-upload/{id}', 'FileUploadController@destroy');

        Route::get('/guru/import', 'GuruController@import');
            Route::post('/guru/import', 'GuruController@importStore');

        Route::get('/siswa/import', 'SiswaController@import');
            Route::post('/siswa/import', 'SiswaController@importStore');
            Route::post('/siswa/reset-password', 'SiswaController@resetPassword');

        Route::get('/profil-sekolah/{sekolah_id}', 'SekolahController@index');
            Route::put('/profil-sekolah/{sekolah_id}', 'SekolahController@update');

        Route::get('/soal/pilih-manual-import/{soal_id}', 'SoalController@pilihManualImport');
        Route::get('/soal/{id}/import-pertanyaan', 'SoalController@importPertanyaan');
        Route::get('/soal/{id}/import-pertanyaan-jawaban', 'SoalController@importPertanyaanJawaban');   
        Route::get('/soal/{id}/copy', 'SoalController@copy');     
            Route::post('/soal/{id}/import-pertanyaan', 'SoalController@importPertanyaanStore');
            Route::post('/soal/{id}/import-pertanyaan-jawaban', 'SoalController@importPertanyaanJawabanStore');
            Route::post('/soal/{id}/copy', 'SoalController@copyStore');
            Route::post('/soal/{id}/copy-pertanyaan-check', 'SoalController@copyPertanyaanCheck');
            Route::post('/soal/{id}/copy-pertanyaan-process', 'SoalController@copyPertanyaanProcess');

        Route::get('/ganti-password/{sch_pic}', 'LoginPertamaKaliController@gantiPassword');
        Route::get('/tidak-ganti-password/{sch_pic}', 'LoginPertamaKaliController@tidakGantiPassword');
            Route::put('/ganti-password/{sch_pic}', 'LoginPertamaKaliController@gantiPasswordUpdate');

        Route::get('/ujian-harian-siswa/{ujian_harian_hasil_id}/hasil', 'UjianHarianSiswaController@hasil');
        
        Route::post('/ujian-harian-jawaban-siswa', 'UjianHarianJawabanSiswaController@store');

        Route::get('/ujian-harian/{ujian_harian_hasil_id}/hasil', 'UjianHarianController@hasilUjian');
            Route::put('/ujian-harian/{ujian_harian_hasil_id}/nilai-essay', 'UjianHarianController@storeScoreEssay');

        Route::post('/{sekolah_id}/logout', 'LoginController@logout');
        
        
        # CRUD
        Route::resource('/guru', 'GuruController');
        Route::resource('/kelas', 'KelasController');
        Route::resource('/pelajaran', 'PelajaranController');
        Route::resource('/tipe-pelajaran', 'PelajaranTipeController');
        Route::resource('/tahun-ajaran', 'TahunAjaranController');
        Route::resource('/siswa', 'SiswaController');
        Route::resource('/jenis-ujian', 'JenisUjianController');
        Route::resource('/rumus-penilaian-ujian', 'RumusPenilaianUjianController');
        Route::resource('/soal', 'SoalController');
        Route::resource('/pertanyaan', 'SoalPertanyaanController');
        Route::resource('/ujian-harian', 'UjianHarianController');
        Route::resource('/ujian-harian-siswa', 'UjianHarianSiswaController');
    }
);

Route::group(
    [
        'middleware' => 'auth:web',
        'prefix' => 'sch/report/ujian-harian',
        'namespace' => 'Sekolah'
    ],
    function () {
        $controller = 'ReportUjianHarianController@';

        Route::get('/', $controller . 'index');
        Route::get('/{ujian_harian_hasil_id}/hasil', $controller . 'hasil');
        Route::get('/export/{ujian_harian_id}/excel/summary', $controller . 'exportSummaryToExcel');
        Route::get('/export/{ujian_harian_hasil_id}/{typeFile}', $controller . 'exportSoalJawabanPersiswa');

        Route::post('/filter', $controller . 'filter');
    }
);