<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    //
    use UuidSekolah;

    public $incrementing = false;

    protected $guarded = [];
}
