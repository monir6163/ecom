<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{
    function Cart(Request $request , $slug = ''){

        if($slug == ''){
            $discount_amount = 0;
            $discount_type = null;
            $min_amount = 0;
            $old_cookie = $request->cookie('cookie_id');
            $carts = Cart::where('cookie_id' , $old_cookie)->get();
            return view('frontend.pages.cart' , [
                'carts'=> $carts,
                'discount_amount'=> $discount_amount,
                'discount_type'=> $discount_type,
                'min_amount'=> $min_amount,
            ]);
        }else{
            $cupon_check = Cupon::where('code' , $slug)->exists();
            if ($cupon_check) {
                if (Carbon::now()->format('Y-m-d') <= Cupon::where('code' , $slug)->first()->end_validity) {
                    $old_cookie = $request->cookie('cookie_id');
                    $carts = Cart::where('cookie_id' , $old_cookie)->get();
                    $discount = Cupon::where('code' , $slug)->first();
                    $discount_amount = $discount->discount_amount;
                    $discount_type = $discount->discount_type;
                    $min_amount = $discount->min_amount;
                    session(['cupon' => $slug]);
                    return view('frontend.pages.cart' , [
                        'carts'=> $carts,
                        'discount_amount'=> $discount_amount,
                        'discount_type'=> $discount_type,
                        'min_amount'=> $min_amount,
                    ]);
                }
                else{
                    return back()->with('ivalid' ,'Expired Cupon Code');
                }
            }
            else{
                return back()->with('ivalid' ,'Invalid Cupon Code');
            } 
        }
        
    }

    function SingleCart($slug , Request $request){
        
        $old_cookie = $request->cookie('cookie_id');
        if($old_cookie){
            $cookie_id = $old_cookie;
        }else{
            $minutes = 43200;
            $cookie_id = Str::random(10);
            Cookie::queue('cookie_id', $cookie_id , $minutes);
        }
        $product_id = Product::where('slug' , $slug)->first()->id;
        $carts = Cart::where('product_id' , $product_id)->where('cookie_id' , $cookie_id);
        if($carts->exists()){
            $carts->increment('quantity');
            return back();
        }else{
            $cart = new Cart;
            $cart->cookie_id = $cookie_id;
            $cart->product_id = $product_id;
            $cart->save();
            return back();
        }
    }

    function ProductCart(Request $request){

        $old_cookie = $request->cookie('cookie_id');
        if($old_cookie){
            $cookie_id = $old_cookie;
        }else{
            $minutes = 43200;
            $cookie_id = Str::random(10);
            Cookie::queue('cookie_id', $cookie_id , $minutes);
        }
        $product_id = Product::findOrFail($request->product_id)->id;
        $carts = Cart::where('product_id' , $product_id)->where('color_id' , $request->color_id)->where('size_id' , $request->size_id)->where('cookie_id' , $cookie_id);
        if($carts->exists()){
            $carts->increment('quantity' , $request->quantity);
            return back();
        }else{
            $cart = new Cart;
            $cart->cookie_id = $cookie_id;
            $cart->product_id = $product_id;
            $cart->color_id = $request->color_id;
            $cart->size_id = $request->size_id;
            $cart->quantity = $request->quantity;
            $cart->save();
            return back();
        }
    }

    function CartUpdate(Request $request){
        
        foreach ($request->cart_id as $key => $cart) {
            Cart::findOrFail($cart)->update([
                'quantity' => $request->quantity[$key],
            ]);
        }
        return back();
    }

    function AjaxCartUpdate(Request $request){

        Cart::findOrFail($request->id)->update([
            'quantity' => $request->qty,
        ]);
    }
}
