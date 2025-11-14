<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employees';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'position',
        'team_id',
        'joining_date',
        'status'
    ];
    // protected $hidden = [];

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

public function releases()
{
    return $this->hasMany(CurrentRelease::class, 'employee_id');
}
}
