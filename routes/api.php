<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APIHomeController;
use App\Http\Controllers\API\APIOrderController;
use App\Http\Controllers\API\APIPaymentController;
use App\Http\Controllers\API\APIWalletController;
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


// api.php
Route::post('/register', [APIAuthController::class,'register']);
Route::post('/login', [APIAuthController::class,'login']);

Route::get('/combos', [APIHomeController::class,'getCombos']);
Route::get('/combos/{id}', [APIHomeController::class,'showCombo']);

Route::get('/get-locations', [APIHomeController::class,'fetchLocations']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/place-order', [APIOrderController::class,'placeOrder']);
    Route::get('/orders', [APIOrderController::class,'fetchUserCombos']);
    Route::get('/orders/{comboId}', [APIOrderController::class,'getOrderDetails']);


    Route::get('/wallet/balance', [APIWalletController::class, 'getWalletBalance']);

    Route::post('/logout', [APIAuthController::class, 'logout']);

    Route::post('/make-payment', [APIPaymentController::class, 'makePayment']);


    
});

Route::get('/categories-with-combos', [APIHomeController::class, 'getAllCategoriesWithCombos']);
Route::get('/combos-by-category/{category}', [APIHomeController::class, 'getCombosByCategory']);

