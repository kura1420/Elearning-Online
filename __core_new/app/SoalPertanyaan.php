<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalPertanyaan extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function soal_pertanyaan_jawabans()
    {
        return $this->hasMany(SoalPertanyaanJawaban::class);
    }
}
