<?php

namespace App\Traits;

trait HasKoperasiId
{
    protected static function bootHasKoperasiId()
    {
        static::creating(function ($model) {
            if (!$model->koperasi_id && auth()->check()) {
                $model->koperasi_id = auth()->user()->koperasi_id;
            }
        });
    }
}
    