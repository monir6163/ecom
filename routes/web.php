<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/mail', function () {
    return view('frontend.invoice.order-mail');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';
//frontend
Route::get('/',[FrontendController::class, 'frontpage'])->name('frontpage');
Route::get('product/{slug}',[FrontendController::class, 'SingleProduct'])->name('SingleProduct');
Route::get('shop',[FrontendController::class, 'Shop'])->name('Shop');
Route::get('cart',[CartController::class, 'Cart'])->name('Cart');
Route::get('cart/{slug}',[CartController::class, 'Cart'])->name('CuponCart');
Route::get('single/cart/{slug}',[CartController::class, 'SingleCart'])->name('SingleCart');
Route::post('product/cart' , [CartController::class, 'ProductCart'])->name('ProductCart');
Route::post('cart/update' , [CartController::class, 'CartUpdate'])->name('CartUpdate');
Route::post('ajax/cart/update' , [CartController::class, 'AjaxCartUpdate'])->name('AjaxCartUpdate');
Route::get('product-size/{size_id}/{color_id}' , [FrontendController::class, 'ProductSize'])->name('ProductSize');
Route::get('checkout',[CheckoutController::class, 'Checkout'])->name('Checkout');
Route::post('checkout',[CheckoutController::class, 'CheckoutPost'])->name('CheckoutPost');
Route::get('api/get-state-list/{slug}',[CheckoutController::class, 'GetState'])->name('GetState');
Route::get('api/get-city-list/{slug}',[CheckoutController::class, 'GetCity'])->name('GetCity');
Route::get('paypal-status',[CheckoutController::class, 'PayPalStatus'])->name('PayPalStatus');
//Admin
//Category Route
Route::get('dashboard',[DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('admin/category-list',[CategoryController::class, 'CategoryList'])->name('CategoryList');
Route::post('admin/category-post',[CategoryController::class, 'CategoryPost'])->name('CategoryPost');
Route::get('admin/category-add',[CategoryController::class, 'CategoryAdd'])->name('CategoryAdd');
Route::get('admin/category-edit/{cat_id}',[CategoryController::class, 'CategoryEdit'])->name('CategoryEdit');
Route::post('admin/category-update',[CategoryController::class, 'CategoryUpdate'])->name('CategoryUpdate');
Route::get('admin/category-delete/{cat_id}',[CategoryController::class, 'CategoryDelete'])->name('CategoryDelete');
Route::get('admin/category-trashlist',[CategoryController::class, 'TrashList'])->name('TrashList');
Route::get('admin/category-trashlist/restore/{cat_id}',[CategoryController::class, 'CategoryRestore'])->name('CategoryRestore');
Route::get('admin/category-trashlist/pdelete/{cat_id}',[CategoryController::class, 'CategoryPermanentDelete'])->name('CategoryPermanentDelete');
Route::post('admin/category/multidelete',[CategoryController::class, 'CategoryMultiDelete'])->name('CategoryMultiDelete');
Route::post('admin/category/multirestore',[CategoryController::class, 'CategoryMultiRestore'])->name('CategoryMultiRestore');

//SubCategory Route
Route::get('admin/subcategory-list',[SubcategoryController::class, 'SubCategoryList'])->name('SubCategoryList');
Route::post('admin/subcategory-post',[SubcategoryController::class, 'SubCategoryPost'])->name('SubCategoryPost');
Route::get('admin/subcategory-add',[SubcategoryController::class, 'SubCategoryAdd'])->name('SubCategoryAdd');
Route::get('admin/subcategory-edit/{scat_id}',[SubCategoryController::class, 'SubCategoryEdit'])->name('SubCategoryEdit');
Route::post('admin/subcategory-update',[SubcategoryController::class, 'SubCategoryUpdate'])->name('SubCategoryUpdate');
Route::get('admin/subcategory-delete/{scat_id}',[SubcategoryController::class, 'SubCategoryDelete'])->name('SubCategoryDelete');
Route::get('admin/subcategory-trashlist',[SubcategoryController::class, 'SubCategoryTrashList'])->name('SubCategoryTrashList');
Route::get('admin/subcategory-trashlist/restore/{scat_id}',[SubcategoryController::class, 'SubCategoryRestore'])->name('SubCategoryRestore');
Route::get('admin/subcategory-trashlist/pdelete/{scat_id}',[SubcategoryController::class, 'SubCategoryPermanentDelete'])->name('SubCategoryPermanentDelete');
Route::post('admin/subcategory/multidelete',[SubcategoryController::class, 'SubCategoryMultiDelete'])->name('SubCategoryMultiDelete');
Route::post('admin/subcategory/submultideleterestore',[SubcategoryController::class, 'SubCategoryMultiRestore'])->name('SubCategoryMultiRestore');

//Product Route
Route::get('admin/get-subcat-api/{subcat_id}',[ProductController::class, 'GetSubCategory'])->name('GetSubCategory');
Route::get('admin/product-list',[ProductController::class, 'ProductList'])->name('ProductList');
Route::get('admin/product-add',[ProductController::class, 'ProductAdd'])->name('ProductAdd');
Route::post('admin/product-post',[ProductController::class, 'ProductPost'])->name('ProductPost');
Route::get('admin/product-edit/{product_id}',[ProductController::class, 'ProductEdit'])->name('ProductEdit');
Route::post('admin/product-update',[ProductController::class, 'ProductUpdate'])->name('ProductUpdate');
Route::get('admin/product-delete/{product_id}',[ProductController::class, 'ProductDelete'])->name('ProductDelete');
Route::post('admin/product/multidelete',[ProductController::class, 'ProductMultiDelete'])->name('ProductMultiDelete');
Route::get('admin/product-trashlist',[ProductController::class, 'ProductTrash'])->name('ProductTrash');
Route::get('admin/product-trashlist/restore/{product_id}',[ProductController::class, 'ProductRestore'])->name('ProductRestore');
Route::post('admin/product/productmultirestore',[ProductController::class, 'ProductMultiRestore'])->name('ProductMultiRestore');

//Product Brand Route
Route::get('admin/productbrand-list',[ProductBrandController::class, 'ProductBrandList'])->name('ProductBrandList');
Route::get('admin/productbrand-add',[ProductBrandController::class, 'ProductBrandAdd'])->name('ProductBrandAdd');
Route::post('admin/productbrand-post',[ProductBrandController::class, 'ProductBrandPost'])->name('ProductBrandPost');
Route::get('admin/productbrand-edit/{brand_id}',[ProductBrandController::class, 'ProductBrandEdit'])->name('ProductBrandEdit');
Route::post('admin/productbrand-update',[ProductBrandController::class, 'ProductBrandUpdate'])->name('ProductBrandUpdate');
Route::get('admin/productbrnad-delete/{brand_id}',[ProductBrandController::class, 'ProductBrandDelete'])->name('ProductBrandDelete');
Route::get('admin/productbrand-trashlist',[ProductBrandController::class, 'ProductBrandTrashList'])->name('ProductBrandTrashList');
Route::get('admin/brand-trashlist/restore/{brand_id}',[ProductBrandController::class, 'BrandRestore'])->name('BrandRestore');
Route::get('admin/brand-trashlist/pdelete/{brand_id}',[ProductBrandController::class, 'BrandPermanentDelete'])->name('BrandPermanentDelete');
Route::post('admin/brand/multidelete',[ProductBrandController::class, 'BrandMultiDelete'])->name('BrandMultiDelete');
Route::post('admin/brand/multirestore',[ProductBrandController::class, 'BrandMultiRestore'])->name('BrandMultiRestore');

//Product Color
Route::get('admin/productcolor-list' , [ColorController::class, 'ProductColorList'])->name('ProductColorList');
Route::get('admin/productcolor-add',[ColorController::class, 'ProductColorAdd'])->name('ProductColorAdd');
Route::post('admin/productcolor-post',[ColorController::class, 'ProductColorPost'])->name('ProductColorPost');
Route::get('admin/productcolor-edit/{color_id}',[ColorController::class, 'ProductColorEdit'])->name('ProductColorEdit');
Route::post('admin/productcolor-update',[ColorController::class, 'ProductColorUpdate'])->name('ProductColorUpdate');
Route::get('admin/productcolor-delete/{color_id}',[ColorController::class, 'ProductColorDelete'])->name('ProductColorDelete');
Route::get('admin/productcolor-trashlist',[ColorController::class, 'ProductColorTrashList'])->name('ProductColorTrashList');
Route::get('admin/color-trashlist/restore/{color_id}',[ColorController::class, 'ColorRestore'])->name('ColorRestore');
Route::get('admin/color-trashlist/pdelete/{color_id}',[ColorController::class, 'ColorPermanentDelete'])->name('ColorPermanentDelete');
Route::post('admin/color/multidelete',[ColorController::class, 'ColorMultiDelete'])->name('ColorMultiDelete');
Route::post('admin/color/multirestore',[ColorController::class, 'ColorMultiRestore'])->name('ColorMultiRestore');
//Product Size
Route::get('admin/productsize-list' , [SizeController::class, 'ProductSizeList'])->name('ProductSizeList');
Route::get('admin/productsize-add',[SizeController::class, 'ProductSizeAdd'])->name('ProductSizeAdd');
Route::post('admin/productsize-post',[SizeController::class, 'ProductSizePost'])->name('ProductSizePost');
Route::get('admin/productsize-edit/{size_id}',[SizeController::class, 'ProductSizeEdit'])->name('ProductSizeEdit');
Route::post('admin/productsize-update',[SizeController::class, 'ProductSizeUpdate'])->name('ProductSizeUpdate');
Route::get('admin/productsize-delete/{size_id}',[SizeController::class, 'ProductSizeDelete'])->name('ProductSizeDelete');
Route::get('admin/productsize-trashlist',[SizeController::class, 'ProductSizeTrashList'])->name('ProductSizeTrashList');
Route::get('admin/size-trashlist/restore/{size_id}',[SizeController::class, 'SizeRestore'])->name('SizeRestore');
Route::get('admin/size-trashlist/pdelete/{size_id}',[SizeController::class, 'SizePermanentDelete'])->name('SizePermanentDelete');
Route::post('admin/size/multidelete',[SizeController::class, 'SizeMultiDelete'])->name('SizeMultiDelete');
Route::post('admin/size/multirestore',[SizeController::class, 'SizeMultiRestore'])->name('SizeMultiRestore');
//Product Cupon
Route::get('admin/cupons' , [CuponController::class, 'cupon'])->name('cupon');
Route::post('admin/cupons' , [CuponController::class, 'CuponPost'])->name('CuponPost');
Route::get('/redirects' , function(){
    return redirect(Redirect::intended()->getTargetUrl());
});