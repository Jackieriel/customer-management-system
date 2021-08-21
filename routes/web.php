<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteGroup;

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

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'getCustomerById']);
Route::post('/add-customers', [App\Http\Controllers\CustomerController::class, 'addCustomer'])->name('addCustomer');
Route::put('/update-customers', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('updateCustomer');
Route::delete('/deleteCustomer/{id}', [App\Http\Controllers\CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
