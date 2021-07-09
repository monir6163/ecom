<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    function cupon(){

        return view('backend.cupon.cupon-form' , [
            'cupons' => Cupon::latest()->get(),
        ]);
    }

    function CuponPost(Request $request){

        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'start_validity' => 'required',
            'end_validity' => 'required',
            'discount_type' => 'required',
            'discount_amount' => 'required',
            'min_amount' => 'required',
        ] , 
        [
            'name.required' => 'Cupon Name Required.',
            'code.required' => 'Cupon Code Required.',
            'start_validity.required' => 'Start-Validity Required.',
            'end_validity.required' => 'End-Validity Required.',
            'discount_type.required' => 'Discount-Type Required.',
            'discount_amount.required' => 'Discount-Amount Required.',
            'min_amount.required' => 'Min-Amount Required.',
        ]);
        $Cupon = new Cupon;
        $Cupon->name = $request->name;
        $Cupon->code = $request->code;
        $Cupon->start_validity = $request->start_validity;
        $Cupon->end_validity = $request->end_validity;
        $Cupon->discount_type = $request->discount_type;
        $Cupon->discount_amount = $request->discount_amount;
        $Cupon->min_amount = $request->min_amount;
        $Cupon->save();
        return back()->with('success','Cupon Created Succcessfully.');
    }
}
