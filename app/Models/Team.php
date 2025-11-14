<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use CrudTrait;
       protected $fillable = ['name', 'team_code', 'description'];

}
