<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_types';
    protected $fillable = [
    	'user_id',
    	'type_name',
    	'project_status',
    ];

    public function projects(){
        return $this->hasMany(Project::class, 'project_type_id', 'id')->withTrashed();
    }
}
