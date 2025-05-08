<?php

namespace App\Models;

use App\Traits\HasKoperasiId;
use App\Traits\HasKoperasiScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PaySalary extends Model
{
    use HasFactory, Sortable, HasKoperasiScope, HasKoperasiId;

    protected $fillable = [
        'employee_id',
        'date',
        'paid_amount',
        'advance_salary',
        'due_salary',
        'koperasi_id',
    ];

    public $sortable = [
        'employee_id',
        'date',
        'paid_amount',
        'advance_salary',
        'due_salary',
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = ['employee'];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
