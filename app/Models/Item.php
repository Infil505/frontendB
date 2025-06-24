<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // App\Models\Item.php
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected $fillable = [
        'name',
        'type',
        'brand',
        'price',
        'discount',
        'final_price',
        'stock',
        'short_description',
        'category_id',
    ];

}
