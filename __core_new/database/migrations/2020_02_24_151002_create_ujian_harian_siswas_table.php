<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianHarianSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_harian_siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('status', 2);
            $table->uuid('tahun_ajaran_id');
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('soal_id');
            $table->uuid('siswa_id');
            $table->uuid('ujian_harian_id');

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
        Schema::dropIfExists('ujian_harian_siswas');
    }
}
