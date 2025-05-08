<?php

namespace App\Models;

use App\Traits\HasKoperasiId;
use App\Traits\HasKoperasiScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory, Sortable, HasKoperasiScope, HasKoperasiId;

    protected $fillable = [
        'name',
        'slug',
        'koperasi_id',
    ];

    protected $sortable = [
        'name',
        'slug',
    ];

    protected $guarded = [
        'id',
    ];

    public function scopeFilter($query, array $filters)
    {
    $query->when($filters['search'] ?? false, function ($query, $search) {
      return $query->where(function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%')
          ->orWhere('slug', 'like', '%' . $search . '%');
      });
    });
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
