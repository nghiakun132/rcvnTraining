<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Users
Route::get('/users',[App\http\Controllers\Api\UserController::class,'index']);
Route::post('/users',[App\http\Controllers\Api\UserController::class,'store']);
Route::get('/users/{id}',[App\http\Controllers\Api\UserController::class,'show']);
Route::put('/users/{id}',[App\http\Controllers\Api\UserController::class,'update']);
Route::delete('/users/{id}',[App\http\Controllers\Api\UserController::class,'destroy']);
//Product
Route::get('/products',[App\http\Controllers\Api\ProductController::class,'index']);
Route::post('/products',[App\http\Controllers\Api\ProductController::class,'store']);
Route::get('/products/{id}',[App\http\Controllers\Api\ProductController::class,'show']);
Route::put('/products/{id}',[App\http\Controllers\Api\ProductController::class,'update']);
Route::delete('/products/{id}',[App\http\Controllers\Api\ProductController::class,'destroy']);
//Customer
Route::get('/customers',[App\http\Controllers\Api\CustomerController::class,'index']);
Route::post('/customers',[App\http\Controllers\Api\CustomerController::class,'store']);
Route::get('/customers/{id}',[App\http\Controllers\Api\CustomerController::class,'show']);
Route::put('/customers/{id}',[App\http\Controllers\Api\CustomerController::class,'update']);
Route::delete('/customers/{id}',[App\http\Controllers\Api\CustomerController::class,'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

