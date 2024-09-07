<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class,'signupForm'])->name('signupform');
Route::post('/signup', [AuthController::class,'signup'])->name('signup');
Route::get('/signin', [AuthController::class,'signinForm'])->name('signinform');
Route::post('/signin', [AuthController::class,'signin'])->name('login');


Route::middleware('auth')->group(function (){
Route::post('/logout', [AuthController::class,'logout'])->name('logout');    
Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
Route::get('/addproject',[ProjectController::class,'addproject'])->name('addproject');
Route::post('/storeproject',[ProjectController::class,'storeproject'])->name('storeproject');
Route::get('/addtask',[TaskController::class,'addTask'])->name('addtask');
Route::post('/storetask',[TaskController::class,'storeTask'])->name('storetask');
Route::get('/edit_project/{id}',[ProjectController::class,'edit_project'])->name('edit_project');
Route::put('/update_project/{id}',[ProjectController::class,'update_project'])->name('update_project');
Route::get('/delete_project/{id}',[ProjectController::class,'delete_project'])->name('delete_project');
Route::get('/edit_task/{id}',[TaskController::class,'edit_task'])->name('edit_task');
Route::put('/update_task/{id}',[TaskController::class,'update_task'])->name('update_task');
Route::get('/delete_task/{id}',[TaskController::class,'delete_task'])->name('delete_task');
Route::get('/mark-as-read', [DashboardController::class,'markAsRead'])->name('mark-as-read');
Route::get('/delete_notification', [DashboardController::class,'deleteNotification'])->name('delete_notification');
Route::get('/products', [ProductController::class,'allproducts'])->name('product');
Route::get('/products/create', [ProductController::class,'create'])->name('createproduct');  
Route::post('/products/store', [ProductController::class,'store'])->name('product.store');
Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('product.edit');
Route::put('/update/products/{id}', [ProductController::class,'update'])->name('product.update');

Route::delete('/delete/{product}', [ProductController::class,'delete'])->name('product.delete');
});


