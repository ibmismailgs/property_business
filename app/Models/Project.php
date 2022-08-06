<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';
    protected $fillable = [
        'project_type_id',
        'project_name',
        'project_packages',
        'project_value',
        'project_duration',
        'implementing_agency',
        'start_date',
        'completed_date',
    ];


    public function packages(){
        return $this->belongsTo(ProjectType::class, 'project_type_id', 'id')->withTrashed();
    }

    public function assigns(){
        return $this->hasMany(ProjectAssign::class, 'project_id', 'id')->withTrashed();
    }
    public function componentdetails(){
        return $this->hasMany(ProjectComponentDetail::class, 'project_id', 'id')->withTrashed();
    }
    public function components()
    {
        return $this->belongsToMany(Component::class, 'project_component_details')
        ->wherePivot('deleted_at', null)
        ->withPivot('id','component_id','project_id','total','gob','others_rpa','dpa')
        ->withTimestamps()->withTrashed();
    }
}
