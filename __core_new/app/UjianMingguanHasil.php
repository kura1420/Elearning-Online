<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class UjianMingguanHasil extends Model
{
    //
    use Uuid;

    public $incrementing = false;

    protected $guarded = [];
}
