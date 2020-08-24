<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelajaran extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function pelajaran_tipes()
    {
        return $this->hasMany(PelajaranTipe::class);
    }
}
