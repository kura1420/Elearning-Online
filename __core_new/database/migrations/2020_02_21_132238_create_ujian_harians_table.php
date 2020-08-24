<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_harians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul', 255);
            $table->date('tanggal');
            $table->char('waktu_mulai', 5);
            $table->char('waktu_habis', 5);
            $table->integer('total_waktu_pengerjaan', false, false);
            $table->boolean('tampilkan_nilai')->default(0);
            $table->boolean('alert_simpan_jawaban')->default(0);
            $table->integer('batas_kelulusan', false, false)->nullable();
            $table->integer('pertanyaan_acak')->default(0);
            $table->uuid('soal_id');
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('jenis_ujian_id');
            $table->uuid('rumus_penilaian_ujian_id');
            $table->uuid('tahun_ajaran_id');

            $table->uuid('sekolah_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujian_harians');
    }
}
