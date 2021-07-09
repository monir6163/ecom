<?php
use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

function cart(){
    
        $old_cookie = Cookie::get('cookie_id');
        return $carts = Cart::where('cookie_id' , $old_cookie)->get();
        
    }
?>