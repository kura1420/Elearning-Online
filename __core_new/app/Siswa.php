<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function siswa_kelas()
    {
        return $this->hasMany(SiswaKelas::class);
    }

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
}
