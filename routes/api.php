<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SellerController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/products',[ProductController::class,'index'])->name('products.index');
Route::get('/products/{product}',[ProductController::class,'show'])->name('products.show');
Route::post('/registerseller',[SellerController::class,'register'])->name('seller.register');
Route::post('/login',[SellerController::class,'login'])->name('seller.login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products',[ProductController::class,'store'])->name('products.store');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('product/{product}',[ProductController::class,'destroy'])->name('products.destroy');
    Route::post('/logout', [SellerController::class, 'logout'])->name('seller.logout');;
});




