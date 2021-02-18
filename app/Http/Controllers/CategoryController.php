<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    function CategoryList(){
        // $categories = Category::all();
        return view('backend.category.category_list', [
            'categories' => Category::orderBy('id','desc')->simplepaginate(3),
            'cat_count' => Category::count()
        ]);
    }
    function CategoryAdd(){
        return view('backend.category.category_form');
    }
    function CategoryPost(Request $request){
        $request->validate([
            'category_name' => ['required', 'min:3', 'max:30', 'unique:categories']
        ],
        [
            'category_name.required' => 'The category name field is Required.'
        ]);
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'created_at' => Carbon::now()
        // ]);
        $cat = new Category;
        $cat->category_name = $request->category_name;
        $cat->save();
        return redirect('admin/category-list')->with('success','Category Create Succcessfully.');
    }
    function CategoryEdit($id){
        return view('backend.category.category_edit', [
            'category' => Category::findOrFail($id),
        ]);
    }
    function CategoryUpdate(Request $request){
        $category = Category::findOrFail($request->category_id);
        $category->category_name = $request->category_name;
        $category->save();
        return redirect('admin/category-list')->with('success','Category Update Succcessfully.');
    }
    function CategoryDelete($id){
        Category::findOrFail($id)->delete();
        return redirect('admin/category-list')->with('delete','Category Delete Succcessfully.');
    }
}
