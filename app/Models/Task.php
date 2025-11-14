<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tasks';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];



    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'status',
        'due_date',
    ];
    // protected $hidden = [];
 public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
