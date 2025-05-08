<?php

namespace App\Models;

use App\Traits\HasKoperasiId;
use App\Traits\HasKoperasiScope;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sortable, HasKoperasiScope, HasKoperasiId;

    protected $fillable = [
        'product_name',
        'category_id',
        'supplier_id',
        'product_code',
        'product_garage',
        'product_image',
        'product_store',
        'buying_date',
        'expire_date',
        'buying_price',
        'selling_price',
        'koperasi_id',
    ];

    public $sortable = [
        'product_name',
        'selling_price',
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        'category',
        'supplier'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        });
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
