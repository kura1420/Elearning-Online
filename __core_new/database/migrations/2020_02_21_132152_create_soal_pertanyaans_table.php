<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalPertanyaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_pertanyaans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nomor', 4);
            $table->text('pertanyaan');
            $table->char('tipe', 2);
            $table->char('tipe_jawaban', 5)->nullable();
            $table->uuid('soal_id');

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
        Schema::dropIfExists('soal_pertanyaans');
    }
}
