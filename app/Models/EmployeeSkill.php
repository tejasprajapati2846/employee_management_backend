<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    use HasFactory;
    
    protected $table = 'employee_skill';

    protected $fillable = [
        'employee_id', 'skill_id',
    ];

}
