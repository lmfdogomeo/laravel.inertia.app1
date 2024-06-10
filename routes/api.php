<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Product\ApiCountProductController;
use App\Http\Controllers\Api\Product\ApiGetProductController;
use App\Http\Controllers\Api\Product\ApiPerMonthProductController;
use App\Http\Controllers\Api\Product\ApiSelectProductController;
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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.auth.logout');
});

Route::group(["middleware" => 'auth:sanctum'], function() {
    Route::group(["prefix" => 'products', ], function() {
        Route::get("", ApiGetProductController::class)->name("api.product.get");
        Route::get("{uuid}", ApiSelectProductController::class)->name("api.product.select");

        Route::group(["prefix" => 'data'], function() {
            Route::get("count", ApiCountProductController::class)->name("api.product.count");
            Route::get("per-month-by-year", ApiPerMonthProductController::class)->name("api.product.perMonth");
        });
    });
});

Route::group(['middleware' => 'throttle:api'], function () {
    Route::get('/product-categories', [ProductCategoryController::class, 'list'])->name('api.product-categories.list');
    Route::get('/merchant-list', [MerchantController::class, 'list'])->name('api.merchant.list');
});
