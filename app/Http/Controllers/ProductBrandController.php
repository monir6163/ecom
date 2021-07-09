<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    function ProductBrandList(){

        $all_brnad = Brand::orderBy('id' , 'desc')->get();
        return view('backend.brand.productbrand-list' , [
            'brands' => $all_brnad,
            'brand_count' => Brand::count()
        ]);
    }

    function ProductBrandAdd(){

        return view('backend.brand.productbrand-form');
    }

    function ProductBrandPost(Request $request){

        $request->validate([
            'brand_name' => ['required' , 'min:3', 'max:30', 'unique:brands'],
            'slug' => ['required']
        ] , 
        [
            'brand_name.required' => 'The Product Brand Name Required.',
            'slug.required' => 'The Product Brand Slug Required.'
        ]);
        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->slug = $request->slug;
        $brand->save();
        return redirect(route('ProductBrandList'))->with('success','Product Brand Create Succcessfully.');
    }

    function ProductBrandEdit($id){

        return view('backend.brand.productbrand-edit' , [
            'brands' => Brand::findOrFail($id),
        ]);
    }

    function ProductBrandUpdate(Request $request){

        $request->validate([
            'brand_name' => ['required' , 'min:3', 'max:30', 'unique:brands'],
            'slug' => ['required']
        ] , 
        [
            'brand_name.required' => 'The Product Brand Name Required.',
            'slug.required' => 'The Product Brand Slug Required.'
        ]);
        $p_brand = Brand::findOrFail($request->brand_id);
        $p_brand->brand_name = $request->brand_name;
        $p_brand->slug = $request->slug;
        $p_brand->save();
        return redirect(route('ProductBrandList'))->with('success','Product Brand Update Succcessfully.');
    }

    function ProductBrandDelete($id){

        Brand::findOrFail($id)->delete();
        return redirect(route('ProductBrandList'))->with('delete','Product Brand Delete Succcessfully.');
    }

    function ProductBrandTrashList(){

        $brand_trash = Brand::onlyTrashed()->orderBy('id' , 'desc')->get();
        return view('backend.brand.productbrand-trashlist' , [
            'trashed_list' => $brand_trash,
            'trash_count' => Brand::onlyTrashed()->count()
        ]);
    }

    function BrandRestore($id){

        Brand::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success' , 'Brand Restore Successfully.');
    }

    function BrandPermanentDelete($id){

        Brand::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('delete','Brand Permanent Delete Succcessfully.');
    }

    function BrandMultiDelete(Request $request){

        foreach($request->delete as $brand_id){
            Brand::findOrFail($brand_id)->delete();
        }
        return back()->with('delete','Selected Brand Delete Succcessfully.');
    }

    function BrandMultiRestore(Request $request){

        foreach($request->restore as $id){
            Brand::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected Brand Restore Succcessfully.');
    }
}
