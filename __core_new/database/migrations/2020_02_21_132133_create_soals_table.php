<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul', 255);
            $table->text('instruksi')->nullable();
            $table->char('tipe', 2);
            $table->boolean('publish')->default(0);
            $table->uuid('pelajaran_id');
            $table->uuid('pelajaran_tipe_id');
            $table->uuid('kelas_id');
            $table->uuid('user_id');
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
        Schema::dropIfExists('soals');
    }
}
