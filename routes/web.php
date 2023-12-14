<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
//     // return view('admin_pannel.index')->name('home');
// });

Route::get('/',[AdminController::class,'admin_pannel'])->name('home');
Route::post('student-details',[AdminController::class,'student_details'])->name('student_details');
Route::get('student-data',[AdminController::class,'student_data']);
Route::get('/fetch-fees/{studentId}',[AdminController::class,'fetchfees']);
Route::post('add-fees',[AdminController::class,'add_fees']);
Route::post('update-fees',[AdminController::class,'update_fees']);
