<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected  $guard = 'employee-api';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'joining_date',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'employee_skill')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_role', 'employee_id', 'role_id')->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'employee_project','employee_id','project')->withTimestamps();
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_task','employee_id','task_id')->withPivot(['hours']);
    }

}
