<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductGallery;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Image;

use function PHPUnit\Framework\fileExists;

class ProductController extends Controller
{
    function ProductList(){
        $all_product = Product::with(['category','product_gellary'])->latest()->get();
        $last_value = collect(request()->segments())->last();
        $last = Str::of($last_value)->replace('-', ' ');
        return view('backend.product.product-list', [
            'last' => $last,
            'products' => $all_product,
            'product_count' => Product::count()
        ]);
    }

    function ProductAdd(){

        return view('backend.product.product-form', [
            'categories' => Category::orderBy('category_name', 'asc')->get(),
            'brands' => Brand::orderBy('brand_name', 'asc')->get(),
            'colors' => Color::orderBy('color_name' , 'asc')->get(),
            'sizes' => Size::orderBy('size_name' , 'asc')->get(),
        ]);
    }

    function GetSubCategory($subcat_id){

        $sub_cat = SubCategory::where('category_id', $subcat_id)->get();
        return response()->json($sub_cat);
    }

    function ProductPost(Request $request){
        $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'subcategory_id' => ['required'],
            'summery' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'thumbnail' => ['required', 'image'],
            // 'images' => ['required' , 'image']
        ],
        [
            'title.required' => 'The Product Name field is Required.',
            'slug.required' => 'The Product Name Slug field is Required.',
            'brand_id.required' => 'The Product Brand Name field is Required.',
            'category_id.required' => 'The Product Category Name field is Required.',
            'subcategory_id.required' => 'The Product SubCategory Name field is Required.',
            'summery.required' => 'The Product Summery field is Required.',
            'description.required' => 'The Product Description field is Required.',
            'price.required' => 'The Product Price field is Required.',
            'thumbnail.required' => 'The Product Thumbnail field is Required.',
            // 'images.required' => 'The Product Image field is Required.',
        ]);

        $product = new Product;
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->summery = $request->summery;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        $productprices = $request->prices;
        foreach ($productprices as $key => $productprice) {
            $productatt = new ProductAttribute;
            $productatt->product_id = $product->id;
            $productatt->price = $productprice;
            $productatt->quantity = $request->quantity[$key];
            $productatt->color_id = $request->color_name[$key];
            $productatt->size_id = $request->size_name[$key];
            $productatt->save();
        } 

        if($request->hasFile('thumbnail')){
            $img = $request->file('thumbnail');
            $ext = Str::slug($request->title).'.'.$img->getClientOriginalExtension();
            $new = Product::findOrFail($product->id);
            $path = public_path('images/'.$new->created_at->format('Y/m/').$new->id.'/');
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($img)->resize(300,300)->save($path.$ext);
            $new->thumbnail = $ext;
            $new->save();
        }
        if($request->hasFile('image')){
            $images = $request->file('image');
        foreach($images as $image1){

            $img_ext = Str::slug($request->title).'-'.Str::random(3).'.'.$image1->getClientOriginalExtension();
            $path = public_path('images/product-gellary/'.$product->created_at->format('Y/m/').$product->id.'/');
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($image1)->resize(300,300)->save($path.$img_ext);
            $img = new ProductGallery;
            $img->product_id = $product->id;
            $img->image_name = $img_ext;
            $img->save();
        }
        }
        
        return redirect(route('ProductList'))->with('success','Product Add Succcessfully.');
    }

    function ProductEdit($id){

        $p_cat = Product::findOrFail($id);
        return view('backend.product.product-edit', [
            'categories' => Category::orderBy('category_name', 'asc')->get(),
            'brands' => Brand::orderBy('brand_name', 'asc')->get(),
            'product' => $p_cat,
            'subcategories' => SubCategory::where('category_id' , $p_cat->category_id)->orderBy('subcategory_name', 'asc')->get(),
        ]);
    }

    function ProductUpdate(Request $request){

        $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'subcategory_id' => ['required'],
            'summery' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            // 'thumbnail' => ['required', 'image']
            // 'image_name' => ['required', 'image']
        ],
        [
            'title.required' => 'The Product Name field is Required.',
            'slug.required' => 'The Product Name Slug field is Required.',
            'brand_id.required' => 'The Product Brand Name field is Required.',
            'category_id.required' => 'The Product Category Name field is Required.',
            'subcategory_id.required' => 'The Product SubCategory Name field is Required.',
            'summery.required' => 'The Product Summery field is Required.',
            'description.required' => 'The Product Description field is Required.',
            'price.required' => 'The Product Price field is Required.',
            // 'thumbnail.required' => 'The Product Thumbnail field is Required.'
            // 'image_name.required' => 'The Product Image Gel field is Required.'
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->title = $request->title;
        if($request->hasFile('thumbnail')){
            $img = $request->file('thumbnail');
            $ext = Str::slug($product->title).'.'.$img->getClientOriginalExtension();
            $old_path = public_path('images/'.$product->created_at->format('Y/m/').$product->id.'/'.$product->thumbnail);
            if(fileExists($old_path)){
                unlink($old_path);
            }
            $path = public_path('images/'.$product->created_at->format('Y/m/').$product->id.'/');
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($img)->resize(300,300)->save($path.$ext);
            $product->thumbnail = $ext;
        }
        $product->slug = $request->slug;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->summery = $request->summery;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        if($request->hasFile('image_name')){
            $img = $request->file('image_name');
        foreach($img as $key => $image){
            $pg = ProductGallery::findOrFail($request->gellary_id[$key]);
           $img_ext = Str::slug($request->title).'-'.Str::random(3).'.'.$image->getClientOriginalExtension();
           $path = public_path('images/product-gellary/'.$pg->created_at->format('Y/m/').$pg->product_id.'/');
           if(file_exists($path.$pg->image_name)){
               unlink($path.$pg->image_name);
           }
           File::makeDirectory($path, $mode = 0777, true, true);
           Image::make($image)->resize(300,300)->save($path.$img_ext);
        //    $img = new ProductGallery;
           $pg->product_id = $product->id;
           $pg->image_name = $img_ext;
           $pg->save();
        }
        
        }
        return redirect(route('ProductList'))->with('success','Product Update Succcessfully.');
    }

    function ProductDelete($id){

        Product::findOrFail($id)->delete();
        return redirect(route('ProductList'))->with('delete','Product Delete Succcessfully.');
    }

    function ProductMultiDelete(Request $request){

        foreach($request->delete as $product_id){
            Product::findOrFail($product_id)->delete();
        }
        return back()->with('delete','Selected Product Delete Succcessfully.');
    }

    function ProductTrash(){

        $product_trash = Product::onlyTrashed()->orderBy('id' , 'desc')->get();
        return view('backend.product.product-trashlist' , [
            'product_trashed' => $product_trash,
            'ptrash_count' => Product::onlyTrashed()->count(),
        ]);
    }

    function ProductRestore($id){

        Product::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success','Product Restore Succcessfully.');
    }

    function ProductMultiRestore(Request $request){

        foreach($request->prestore as $id){
            Product::onlyTrashed()->findOrFail($id)->restore();
        }
        return back()->with('success','Selected Product Restore Succcessfully.');
    }
}
