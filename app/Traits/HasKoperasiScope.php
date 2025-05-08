<?php

namespace App\Traits;

trait HasKoperasiScope
{
    public function scopeForKoperasi($query)
    {
        if (auth()->user()->roles->contains('name', 'superadmin')) {
            return $query;
        }

        return $query->where('koperasi_id', auth()->user()->koperasi_id);
    }
} 