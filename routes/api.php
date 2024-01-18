<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register',[AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('logout', [AuthController::class,'logout']);
});

Route::apiResource('/brands',BrandController::class)->middleware('is_admin');
Route::apiResource('/categories',CategoryController::class)->middleware('is_admin');
Route::apiResource('/locations',LocationController::class)->middleware('auth');

//product
Route::prefix('product')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('index', 'index')->middleware('auth');
        Route::get('show/{id}', 'index')->middleware('auth');
        Route::post('store', 'store')->middleware('is_admin');
        Route::put('update/{id}', 'update')->middleware('is_admin');
        Route::delete('destroy/{id}', 'destroy')->middleware('is_admin');
    });
});

//order

Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('index', 'index')->middleware('is_admin');
        Route::get('show/{id}', 'index')->middleware('is_admin');
        Route::post('store', 'store')->middleware('auth');
        Route::get('get_order_item/{id}', 'get_order_item')->middleware('is_admin');
        Route::get('get_user_order/{id}', 'get_user_order')->middleware('is_admin');
    });
});
