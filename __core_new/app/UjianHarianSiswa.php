<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UjianHarianSiswa extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function ujian_harian_jawaban_siswas()
    {
        return $this->hasMany(UjianHarianJawabanSiswa::class);
    }
}
