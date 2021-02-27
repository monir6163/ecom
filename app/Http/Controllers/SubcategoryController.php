<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    function SubCategoryList(){
        $all_subcat = SubCategory::orderBy('id', 'desc')->get();
        return view('backend.subcategory.subcategory_list', [

            'subcategories' => $all_subcat,
            'subcat_count' => SubCategory::count()
        ]);
    }

    function SubCategoryAdd(){

        return view('backend.subcategory.subcategory_form', [
            'categories' => Category::orderBy('category_name','asc')->get(),
        ]);
    }

    function SubCategoryPost(Request $request){

        $request->validate([
            'subcategory_name' => ['required', 'min:3', 'max:30', 'unique:sub_categories'],
            'slug' => ['required'],
            'category_id' => ['required']
        ],
        [
            'subcategory_name.required' => 'The SubCategory name field is Required.',
            'slug.required' => 'The SubCategory Slug field is Required.',
            'category_id.required' => 'Please Select Category Name.'
        ]);
        $scat = new SubCategory;
        $scat->subcategory_name = $request->subcategory_name;
        $scat->category_id = $request->category_id;
        // $scat->slug = Str::slug($request->subcategory_name);
        $scat->slug = $request->slug;
        $scat->save();
        return redirect('admin/subcategory-list')->with('success','SubCategory Create Succcessfully.');
    }

    function SubCategoryEdit($scat_id){

        return view('backend.subcategory.subcategory_edit', [
            'scat' => SubCategory::findOrFail($scat_id),
            'categories' => Category::orderBy('category_name','asc')->get()
        ]);
    }

    function SubCategoryUpdate(Request $request){

        $request->validate([
            'subcategory_name' => ['required', 'min:3', 'max:30', 'unique:sub_categories'],
            'category_id' => ['required']
        ],
        [
            'subcategory_name.required' => 'The SubCategory name field is Required.',
            'category_id.required' => 'Please Select Category Name.'
        ]);

        $scat = SubCategory::findOrFail($request->id);
        $scat->subcategory_name = $request->subcategory_name;
        $scat->category_id = $request->category_id;
        // $scat->slug = Str::slug($request->subcategory_name);
        $scat->slug = $request->slug;
        $scat->save();
        return redirect(route('SubCategoryList'))->with('success','SubCategory Create Update Succcessfully.');
    }

    function SubCategoryDelete($id){

        SubCategory::findOrFail($id)->delete();
        return redirect('admin/subcategory-list')->with('delete','SubCategory Delete Succcessfully.');
    }

    function SubCategoryTrashList(){
        $subcat_trash = SubCategory::onlyTrashed()->orderBy('id' , 'desc')->get();
        return view('backend.subcategory.subcategory_trashlist', [
            'sub_trashed_list' => $subcat_trash,
            'subcat_count' => SubCategory::onlyTrashed()->count()
        ]);
    }

    function SubCategoryRestore($id){

        SubCategory::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success','SubCategory Restore Succcessfully.');
    }

    function SubCategoryPermanentDelete($id){

        SubCategory::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('delete','SubCategory Permanent Delete Succcessfully.');
    }

    function SubCategoryMultiDelete(Request $request){

        foreach($request->delete as $scat_id){
            SubCategory::findOrFail($scat_id)->delete();
        }
        return back()->with('delete','Selected SubCategory Delete Succcessfully.');
    }

    function SubCategoryMultiRestore(Request $request){

        foreach($request->subrestore as $id){
            SubCategory::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected SubCategory Restore Succcessfully.');
    }
}
