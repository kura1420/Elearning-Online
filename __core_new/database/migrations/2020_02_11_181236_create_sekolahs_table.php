<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('npsn', 100)->nullable();
            $table->string('nama', 255);
            $table->string('status', 50);
            $table->string('pendidikan', 30);
            $table->string('logo', 255)->nullable();
            $table->text('alamat');
            $table->string('email', 100)->nullable();
            $table->char('telp', 14)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('singkatan', 50)->unique();
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
        Schema::dropIfExists('sekolahs');
    }
}
