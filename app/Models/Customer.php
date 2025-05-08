<?php

namespace App\Models;

use App\Traits\HasKoperasiId;
use App\Traits\HasKoperasiScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Customer extends Model
{
    use HasFactory, Sortable, HasKoperasiScope, HasKoperasiId;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'shopname',
        'photo',
        'account_holder',
        'account_number',
        'bank_name',
        'bank_branch',
        'city',
        'koperasi_id',
    ];
    public $sortable = [
        'name',
        'email',
        'phone',
        'shopname',
        'city',
    ];

    protected $guarded = [
        'id',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')->orWhere('shopname', 'like', '%' . $search . '%');
        });
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
