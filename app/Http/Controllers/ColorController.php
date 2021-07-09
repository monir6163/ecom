<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    function ProductColorList(){

        $all_color = Color::orderBY('id' , 'desc')->get();
        return view('backend.color.productcolor-list' , [

            'colors' => $all_color,
            'color_count' => Color::count(),
        ]);
    }

    function ProductColorAdd(){

        return view('backend.color.product-color-form');
    }

    function ProductColorPost(Request $request){

        $request->validate([
            'color_name' => ['required' , 'min:3', 'max:30', 'unique:colors'],
        ], 
        [
            'color_name.required' =>'The Color Name Field Required.',
        ]);
        $color = new Color;
        $color->color_name = $request->color_name;
        $color->save();
        return redirect(route('ProductColorList'))->with('success','Product Color Create Succcessfully.');
    }

    function ProductColorEdit($id){

        return view('backend.color.productcolor-edit' , [

            'colors' => Color::findOrFail($id),
        ]);
    }

    function ProductColorUpdate(Request $request){

        $request->validate([
            'color_name' => ['required' , 'min:3', 'max:30', 'unique:colors'],
        ] , 
        [
            'color_name.required' => 'The Product Color Name Required.',
        ]);
        $p_color = Color::findOrFail($request->color_id);
        $p_color->color_name = $request->color_name;
        $p_color->save();
        return redirect(route('ProductColorList'))->with('success','Product Color Update Succcessfully.');
    }

    function ProductColorDelete($id){

        Color::findOrFail($id)->delete();
        return back()->with('delete','Product Color Delete Succcessfully.');
    }

    function ProductColorTrashList(){

        $color_trash = Color::onlyTrashed('id' , 'desc')->get();
        return view('backend.color.productcolor-trashlist' , [
            'trash_list' => $color_trash,
            'trash_count' => Color::onlyTrashed()->count(),
        ]);
    }

    function ColorRestore($id){

        Color::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success' , 'Color Restore Successfully.');
    }

    function ColorPermanentDelete($id){

        Color::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('delete','Color Permanent Delete Succcessfully.');
    }

    function ColorMultiDelete(Request $request){

        foreach($request->delete as $color_id){
            Color::findOrFail($color_id)->delete();
        }
        return back()->with('delete','Selected Color Delete Succcessfully.');
    }

    function ColorMultiRestore(Request $request){

        foreach($request->restore as $id){
            Color::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected Color Restore Succcessfully.');
    }
}
