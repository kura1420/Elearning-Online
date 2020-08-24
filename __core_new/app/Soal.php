<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soal extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function soal_pertanyaans()
    {
        return $this->hasMany(SoalPertanyaan::class);
    }

    public function soal_pertanyaan_jawabans()
    {
        return $this->hasMany(SoalPertanyaanJawaban::class);
    }

    public function ujian_harians()
    {
        return $this->hasMany(UjianHarian::class);
    }
}
