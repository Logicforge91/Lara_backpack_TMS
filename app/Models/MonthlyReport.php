<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use CrudTrait;

     protected $fillable = [
        'task_id',
        'employee_id',
        'task_name',
        'description',
        'status',
        'report_date'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function employee()
{
    return $this->belongsTo(Employee::class);
}

}
