<?php

namespace App\Models\Accounts;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    public function createdBy(): HasMany{
        return $this->hasMany(  User::class,'id','created_by')
            ->withTrashed();
    }

    public function updatedBy(): HasMany{
        return $this->hasMany(  User::class,'id','updated_by')
            ->withTrashed();
    }

    public function bank(): HasMany{
        return $this->hasMany(  Bank::class,'id','bank_id')
            ->withTrashed();
    }
}
