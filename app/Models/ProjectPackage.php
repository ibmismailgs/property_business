<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProjectPackage extends Model
{
    use HasFactory, SoftDeletes;

        public function projects(){
            return $this->belongsTo(Project::class, 'project_id', 'id')->withTrashed();
       }

       public function contactors(){
            return $this->belongsTo(Contactor::class, 'contactor_id', 'id')->withTrashed();
       }

      public function packages(){
            return $this->belongsTo(PackageType::class, 'type_id', 'id')->withTrashed();
       }
}
