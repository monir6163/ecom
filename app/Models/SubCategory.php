<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    function category(){

        return $this->belongsTo(Category::class);
    }

    function sub_product(){

        return $this->hasMany(Product::class, 'subcategory_id');
    }
}
