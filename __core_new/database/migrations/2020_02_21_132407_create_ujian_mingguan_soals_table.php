<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianMingguanSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_mingguan_soals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal');
            $table->char('waktu_mulai', 5);
            $table->char('waktu_habis', 5);
            $table->integer('total_waktu_perngerjaan', false, false);
            $table->boolean('alert_simpan_jawaban')->default(0);
            $table->integer('batas_kelulusan', false, false)->nullable();
            $table->uuid('soal_id');
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('rumus_penilaian_ujian_id');
            $table->uuid('ujian_mingguan_id');

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
        Schema::dropIfExists('ujian_mingguan_soals');
    }
}
