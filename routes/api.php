<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APIHomeController;
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

