<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

trait UuidSekolah
{

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
            $model->sekolah_id = Session::get('sch_id');
        });
    }

}