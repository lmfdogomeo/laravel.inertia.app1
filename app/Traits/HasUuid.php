<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model as EloquentModel;
// use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasUuid {
    protected static function bootHasUuid() {
        static::creating(function(EloquentModel $model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
