<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','status','start_date','end_date'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_task', 'task_id', 'employee_id')->withPivot(['hours'])->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);    
    }
}
