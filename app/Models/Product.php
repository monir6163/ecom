<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    function subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    function color(){
        return $this->belongsTo(Color::class , 'color_id');
    }

    function size(){
        return $this->belongsTo(Size::class , 'size_id');
    }

    function product_gellary(){
        return $this->hasMany(ProductGallery::class, 'product_id');
    }

    function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }

    function product_attr(){
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }
}
