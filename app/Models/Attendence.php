<?php

namespace App\Models;

use App\Traits\HasKoperasiId;
use App\Traits\HasKoperasiScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Attendence extends Model
{
    use HasFactory, Sortable, HasKoperasiScope, HasKoperasiId;

    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'koperasi_id',
    ];

    public $sortable = [
        'employee_id',
        'date',
        'status',
    ];

    protected $guarded = [
        'id'
    ];

    protected $with = [
        'employee',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'date';
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
