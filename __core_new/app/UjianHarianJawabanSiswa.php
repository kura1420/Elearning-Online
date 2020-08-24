<?php

namespace App;

use App\Traits\UuidSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UjianHarianJawabanSiswa extends Model
{
    //
    use UuidSekolah;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];
}
