<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UjianMingguanSoal extends Model
{
    //
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];
}
