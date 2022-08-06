<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id')
            ->withTrashed();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')
            ->withTrashed();
    }
}
