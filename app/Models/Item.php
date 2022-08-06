<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	use HasFactory, SoftDeletes;

	public function packages(){
		return $this->belongsTo(ProjectPackage::class, 'package_id', 'id')->withTrashed();
	}

	public function units(){
		return $this->belongsTo(Unit::class, 'unit_id', 'id')->withTrashed();
	}
}
