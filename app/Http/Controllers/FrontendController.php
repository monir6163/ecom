<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function frontpage() {

        return view('frontend.main' , [
            'latest_products' => Product::with('category','subcategory')->latest()->get(),
        ]);
    }

    function SingleProduct($slug){

        $single_product = Product::where('slug' , $slug)->first();
        $attr = ProductAttribute::where('product_id' , $single_product->id)->get();
        $collect = collect($attr);
        $groupby = $collect->groupBy('color_id');
        return view('frontend.product-details' , [
            'single_product' => $single_product,
            'groupby' => $groupby,
        ]);
    }

    function ProductSize($color, $product){

       $sizes = ProductAttribute::where('product_id' , $product)->where('color_id' , $color)->get();
       return response()->json($sizes);
    //    $output = "";
    //    foreach($sizes as $size){
    //     $output = '<input type="radio" name="size_id" id="size" value="'.$size->size_id.'"><label for="size">'.$size->size->size_name.'</label>';
    //    }
    //    echo $output;
    }

    function Shop(){
        
        return view('frontend.pages.shop' , [
            'categories' => Category::with('product')->OrderBy('category_name' , 'asc')->get(),
            'all_products' => Product::with('category','subcategory')->latest()->get(),
        ]);
    }
}
