<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianMingguanHasilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_mingguan_hasils', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('tanggal');
            $table->boolean('status')->default(0);
            $table->integer('nilai', false, false);
            $table->integer('total_pertanyaan', false, false);
            $table->integer('total_benar', false, false);
            $table->integer('total_salah', false, false);
            $table->integer('pertanyaan_dijawab', false, false);
            $table->integer('pertanyaan_tidak_dijawab', false, false);
            $table->integer('pertanyaan_dijawab_ragu', false, false);
            $table->uuid('soal_id');
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('siswa_id');
            $table->uuid('ujian_mingguan_id');
            $table->uuid('ujian_mingguan_soal_id');

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
        Schema::dropIfExists('ujian_mingguan_hasils');
    }
}
