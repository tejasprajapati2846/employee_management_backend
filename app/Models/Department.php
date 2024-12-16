<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $dates = ['created_at'];

    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

}
