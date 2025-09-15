<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class, 'index'])->name('user.index');
});
Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands',[AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brands/add',[AdminController::class, 'add_brand'])->name('admin.add.brand');
    Route::post('/admin/brands/store',[AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brands/edit/{id}',[AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::post('/admin/brands/update/{id}',[AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brands/delete/{id}',[AdminController::class, 'brand_delete'])->name('admin.brand.delete');


    Route::get('/admin/categories',[AdminController::class, 'categories'])->name('admin.categories'); //show the list of categories
    Route::get('/admin/categories/add',[AdminController::class, 'category_add'])->name('admin.category.add'); //show the form to add a new category
    Route::post('/admin/categories/store',[AdminController::class, 'category_store'])->name('admin.category.store'); //store the new category
    Route::get('/admin/categories/edit/{id}',[AdminController::class, 'category_edit'])->name('admin.category.edit'); //show the form to edit a category
    Route::post('/admin/categories/update/{id}',[AdminController::class, 'category_update'])->name('admin.category.update'); //update the category
    Route::delete('/admin/categories/delete/{id}',[AdminController::class, 'category_delete'])->name('admin.category.delete'); //delete the category

    Route::get('/admin/products',[AdminController::class, 'products'])->name('admin.products'); //show the list of products
});
