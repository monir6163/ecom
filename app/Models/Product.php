<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    function subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    function brand_list(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
