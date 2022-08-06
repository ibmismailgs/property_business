<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'components';

    protected $fillable = [
     'component_code',
     'component_name',
    ];
}
