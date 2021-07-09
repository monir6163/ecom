<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function CategoryList(){
        $all_cat = Category::orderBy('id', 'desc')->get();
        return view('backend.category.category_list', [
            'categories' => $all_cat,
            'cat_count' => Category::count()
        ]);
    }
    function CategoryAdd(){
        
        return view('backend.category.category_form');
    }
    function CategoryPost(Request $request){

        $request->validate([
            'category_name' => ['required', 'min:3', 'max:30', 'unique:categories'],
            'slug' => ['required']
        ],
        [
            'category_name.required' => 'The category name field is Required.',
            'slug.required' => 'The category Slug field is Required.'
        ]);
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'created_at' => Carbon::now()
        // ]);
        $cat = new Category;
        $cat->category_name = $request->category_name;
        // $cat->slug = Str::slug($request->category_name);
        $cat->slug = $request->slug;
        $cat->save();
        return redirect('admin/category-list')->with('success','Category Create Succcessfully.');
        // return back()->with('success','Category Create Succcessfully.');
    }
    function CategoryEdit($id){

        return view('backend.category.category_edit', [
            'category' => Category::findOrFail($id),
        ]);
    }
    function CategoryUpdate(Request $request){

        $request->validate([
            'category_name' => ['required', 'min:3', 'max:30', 'unique:categories'],
            'slug' => ['required']
        ],
        [
            'category_name.required' => 'The category name field is Required.',
            'slug.required' => 'The category Slug field is Required.'
        ]);
        $category = Category::findOrFail($request->category_id);
        $category->category_name = $request->category_name;
        $category->slug = $request->slug;
        $category->save();
        return redirect('admin/category-list')->with('success','Category Update Succcessfully.');
    }
    function CategoryDelete($id){

        Category::findOrFail($id)->delete();
        return redirect('admin/category-list')->with('delete','Category Delete Succcessfully.');
    }
    function TrashList(){
        $cat_trash = Category::onlyTrashed()->orderBy('id' , 'desc')->get();
        return view('backend.category.trash_list', [
            'trashed_list' => $cat_trash,
            'cat_count' => Category::onlyTrashed()->count()
        ]);
    }
    function CategoryRestore($id){

        Category::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success','Category Restore Succcessfully.');
    }
    function CategoryPermanentDelete($id){

        Category::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('delete','Category Permanent Delete Succcessfully.');
    }
    function CategoryMultiDelete(Request $request){

        foreach($request->delete as $cat_id){
            Category::findOrFail($cat_id)->delete();
        }
        return back()->with('delete','Selected Category Delete Succcessfully.');
    }

    function CategoryMultiRestore(Request $request){

        foreach($request->restore as $id){
            Category::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected Category Restore Succcessfully.');
    }
}
