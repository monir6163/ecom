<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

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

Route::get('/admin/contact',[FrontendController::class, 'contact']);//laravel 8
Route::get('dashboard',[DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('admin/category-list',[CategoryController::class, 'CategoryList'])->name('CategoryList');
Route::post('admin/category-post',[CategoryController::class, 'CategoryPost'])->name('CategoryPost');
Route::get('admin/category-add',[CategoryController::class, 'CategoryAdd'])->name('CategoryAdd');
Route::get('admin/category-edit/{cat_id}',[CategoryController::class, 'CategoryEdit'])->name('CategoryEdit');
Route::post('admin/category-update',[CategoryController::class, 'CategoryUpdate'])->name('CategoryUpdate');
Route::get('admin/category-delete/{cat_id}',[CategoryController::class, 'CategoryDelete'])->name('CategoryDelete');