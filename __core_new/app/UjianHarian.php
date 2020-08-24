<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UjianHarian extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function ujian_harian_siswas()
    {
        return $this->hasMany(UjianHarianSiswa::class);
    }

    public function ujian_harian_jawaban_siswas()
    {
        return $this->hasMany(UjianHarianJawabanSiswa::class);
    }

    public function ujian_harian_hasils()
    {
        return $this->hasMany(UjianHarianHasil::class);
    }

    public function soals()
    {
        return $this->belongsToMany(Soal::class);
    }
}
