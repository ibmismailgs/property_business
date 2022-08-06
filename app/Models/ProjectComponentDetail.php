<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProjectComponentDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_component_details';
    protected $fillable = [
     'project_id',
     'component_id',
     'gob',
     'others_rpa',
     'dpa',
     'total',
    ];
}
