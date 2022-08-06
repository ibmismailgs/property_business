<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemInventory extends Model
{
    use HasFactory,SoftDeletes;

       public function items(){
        return $this->belongsTo(InventoryItem::class, 'item_id', 'id')->withTrashed();
       }
       public function category(){
        return $this->belongsTo(InventoryCategory::class, 'category_id', 'id')->withTrashed();
       }

       public function subcategory(){
        return $this->belongsTo(InventorySubCategory::class, 'subcategory_id', 'id')->withTrashed();
       }

       public function group(){
        return $this->belongsTo(InventoryGroup::class, 'group_id', 'id')->withTrashed();
       }
}
