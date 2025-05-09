<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Koperasi extends Model
{
    use HasFactory, Sortable;

    protected $table = 'koperasi';
    
    protected $fillable = [
        'nama_koperasi',
        'alamat',
        'telepon',
        'email',
    ];

    public $sortable = [
        'nama_koperasi',
        'alamat',
        'telepon',
        'email',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama_koperasi', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function attendences()
    {
        return $this->hasMany(Attendence::class);
    }

    public function advanceSalaries()
    {
        return $this->hasMany(AdvanceSalary::class);
    }

    public function paySalaries()
    {
        return $this->hasMany(PaySalary::class);
    }
} 