<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentRelease extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'current_releases';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
     protected $fillable = [
        'name', 'section', 'description', 'status', 'start_date', 'end_date',
        'deadline_date', 'comments', 'code_verified_by', 'story_points'
    ];
    // protected $hidden = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Team that verified code
    public function verifiedTeam()
    {
        return $this->belongsTo(Team::class, 'code_verified_by');
    }

}
