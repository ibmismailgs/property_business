<?php

namespace App\Models\Accounts;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    protected $dates = ['deleted_at','date'];

    public function accounts(): HasMany{
        return $this->hasMany(  Account::class,'id','account_id')
            ->withTrashed();
    }

    public function createdBy(): HasMany{
        return $this->hasMany(  User::class,'id','created_by')
            ->withTrashed();
    }

    public function updatedBy(): HasMany{
        return $this->hasMany(  User::class,'id','updated_by')
            ->withTrashed();
    }
}
