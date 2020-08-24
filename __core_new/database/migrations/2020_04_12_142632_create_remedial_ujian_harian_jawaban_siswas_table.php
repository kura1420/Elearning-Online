<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemedialUjianHarianJawabanSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remedial_ujian_harian_jawaban_siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('tanggal');
            $table->char('tipe', 10);
            $table->text('essay')->nullable();
            $table->uuid('soal_id');
            $table->uuid('soal_pertanyaan_id');
            $table->uuid('soal_pertanyaan_jawaban_id')->nullable();
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('siswa_id');
            $table->uuid('ujian_harian_id');
            $table->uuid('remedial_ujian_harian_id');
            $table->uuid('remedial_ujian_harian_siswa_id');

            $table->uuid('sekolah_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remedial_ujian_harian_jawaban_siswas');
    }
}
