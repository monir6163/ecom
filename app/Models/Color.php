<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;
    use SoftDeletes;

    function attr(){

        return $this->hasMany(ProductAttribute::class , 'color_id');
    }

    function color_product(){

        return $this->hasMany(Product::class, 'color_id');
    }

    function cart(){

        return $this->hasMany(Cart::class , 'color_id');
    }
}
