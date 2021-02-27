<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

// Route::get('/admin/contact',[FrontendController::class, 'contact']);

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