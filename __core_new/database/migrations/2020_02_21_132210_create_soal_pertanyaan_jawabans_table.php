<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalPertanyaanJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_pertanyaan_jawabans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('urutan', 4);
            $table->text('jawaban');
            $table->boolean('benar')->default(0);
            $table->uuid('soal_id');
            $table->uuid('soal_pertanyaan_id');

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
        Schema::dropIfExists('soal_pertanyaan_jawabans');
    }
}
