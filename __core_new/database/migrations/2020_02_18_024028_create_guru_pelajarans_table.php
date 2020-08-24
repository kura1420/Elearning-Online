<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruPelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru_pelajarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('aktif')->default(0);
            $table->uuid('guru_id');
            $table->uuid('pelajaran_id');
            
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
        Schema::dropIfExists('guru_pelajarans');
    }
}
