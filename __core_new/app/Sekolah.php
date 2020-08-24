<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    //
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function pic_sekolahs()
    {
        return $this->hasMany(PicSekolah::class);
    }

    public function jenis_ujians()
    {
        return $this->hasMany(JenisUjian::class);
    }

    public function rumus_penilaian_ujians(Type $var = null)
    {
        return $this->hasMany(RumusPenilaianUjian::class);
    }
}
