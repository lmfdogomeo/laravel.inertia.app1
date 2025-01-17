<?php

use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductCategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'throttle:api'], function () {
    Route::get('/product-categories', [ProductCategoryController::class, 'list'])->name('api.product-categories.list');
    Route::get('/merchant-list', [MerchantController::class, 'list'])->name('api.merchant.list');
});
