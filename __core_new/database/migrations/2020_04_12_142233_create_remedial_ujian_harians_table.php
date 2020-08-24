<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemedialUjianHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remedial_ujian_harians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul', 255)->nullable();
            $table->date('tanggal');
            $table->char('waktu_mulai', 5);
            $table->char('waktu_habis', 5);
            $table->integer('total_waktu_pengerjaan', false, false);
            $table->boolean('tampilkan_nilai')->default(0);
            $table->integer('alert_simpan_jawaban', false, false);
            $table->integer('batas_kelulusan', false, false);
            $table->boolean('pertanyaan_acak')->default(0);
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
        Schema::dropIfExists('remedial_ujian_harians');
    }
}
