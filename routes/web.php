<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('main');
Route::get('admin-dashboard',[AdminController::class,'admin_pannel'])->name('home');
Route::post('student-details',[AdminController::class,'student_details'])->name('student_details');
Route::get('student-data',[AdminController::class,'student_data']);
Route::get('/fetch-fees/{studentId}',[AdminController::class,'fetchfees']);
Route::post('add-fees',[AdminController::class,'add_fees']);
Route::post('update-fees',[AdminController::class,'update_fees']);


Route::get('user_dashboard',[HomeController::class,'user_dashboard'])->name('user_dashboard');

Route::get('login' ,[AdminController::class,'login'])->name('login');
Route::get('register' ,[AdminController::class,'register'])->name('register');
Route::post('admin-login',[LoginController::class,'admin_login'])->name('admin_login');
Route::post('admin-register',[LoginController::class,'admin_register'])->name('admin_register');
Route::get('logout',[loginController::class,'logout'])->name('logout');


