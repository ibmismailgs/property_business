<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAssign extends Model
{
    use HasFactory, SoftDeletes;

    public function projects(){
        return $this->belongsTo(Project::class, 'project_id', 'id')->withTrashed();
    }

    public function employees(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id')->withTrashed();
    }
}
