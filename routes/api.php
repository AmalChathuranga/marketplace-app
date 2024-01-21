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
Route::group(['prefix'=>'marketplace','as'=>'marketplace'], function(){
    Route::get('/products',[ProductController::class,'index'])->name('products.index');
    Route::get('/products/{product}',[ProductController::class,'show'])->name('products.show');
    Route::post('/registerseller',[SellerController::class,'register'])->name('seller.register');
    Route::post('/login',[SellerController::class,'login'])->name('seller.login');


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/products',[ProductController::class,'store'])->name('product.store');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::post('/logout', [SellerController::class, 'logout'])->name('seller.logout');
        Route::post('/storesellerproducts',[SellerController::class,'storeSellerProducts']);
        Route::get('/getsellerproducts',[SellerController::class,'getSellerProductList'])->name('seller.products');
        Route::get('/getproductsellers/{id}',[ProductController::class,'getProductSellers'])->name('product.seller');
});

});



