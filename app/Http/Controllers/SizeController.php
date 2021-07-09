<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    function ProductSizeList(){

        $all_size = Size::orderBy('id' , 'desc')->get();
        return view('backend.size.productsize-list' , [
            'sizes' => $all_size,
            'size_count' => Size::count(),
        ]);
    }

    function ProductSizeAdd(){

        return view('backend.size.productsize-form');
    }

    function ProductSizePost(Request $request){

        $request->validate([
            'size_name' => ['required' , 'min:1', 'max:30', 'unique:sizes'],
        ] ,
        [
            'size_name.required' => 'The Product Size Field Required.',
        ]);
        $p_size = new Size;
        $p_size->size_name = $request->size_name;
        $p_size->save();
        return redirect(route('ProductSizeList'))->with('success','Product Size Create Succcessfully.');
    }

    function ProductSizeEdit($id){

        return view('backend.size.productsize-edit' , [
            'sizes' => Size::findOrFail($id),
        ]);
    }

    function ProductSizeUpdate(Request $request){
        $request->validate([
            'size_name' => ['required' , 'min:1', 'max:30', 'unique:sizes'],
        ] , 
        [
            'size_name.required' => 'The Product Size Field Required.',
        ]);
        $p_sizes = Size::findOrFail($request->size_id);
        $p_sizes->size_name = $request->size_name;
        $p_sizes->save();
        return redirect(route('ProductSizeList'))->with('success','Product Size Update Succcessfully.');
    }

    function ProductSizeDelete($id){

        Size::findOrFail($id)->delete();
        return back()->with('delete','Product Size Delete Succcessfully.');
    }

    function ProductSizeTrashList(){

        $trash_list = Size::onlyTrashed('id' , 'desc')->get();
        return view('backend.size.productsize-trashlist' , [
            'size_list' => $trash_list,
            'trash_count' => Size::onlyTrashed()->count(),
        ]);
    }

    function SizeRestore($id){

        Size::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success' , 'Size Restore Successfully.');
    }

    function SizePermanentDelete($id){

        Size::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('delete','Size Permanent Delete Succcessfully.');
    }

    function SizeMultiDelete(Request $request){

        foreach($request->delete as $size_id){
            Size::findOrFail($size_id)->delete();
        }
        return back()->with('delete','Selected Size Delete Succcessfully.');
    }

    function SizeMultiRestore(Request $request){

        foreach($request->restore as $id){
            Size::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected Size Restore Succcessfully.');
    }
}
