<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

trait Uuid
{

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

}