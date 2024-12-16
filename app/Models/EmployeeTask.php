<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    use HasFactory;

    protected $table = 'employee_task';

    protected $fillable = [
        'employee_id', 'task_id',
    ];

}
