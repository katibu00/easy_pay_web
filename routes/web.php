<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'login']);

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/home/admin', [HomeController::class,'admin'])->name('home.admin');
});


Route::prefix('products')->middleware(['auth'])->group(function () {
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/index', [ProductController::class, 'index'])->name('products.index');
});


Route::prefix('combos')->middleware(['auth'])->group(function () {
    Route::get('/create', [ComboController::class, 'create'])->name('combos.create');
    Route::post('/store', [ComboController::class, 'store'])->name('combos.store');
    Route::get('/index', [ComboController::class, 'index'])->name('combos.index');
    Route::get('/{combo}', [ComboController::class, 'show'])->name('combos.show');
    Route::get('/{combo}/edit', [ComboController::class, 'edit'])->name('combos.edit');
    Route::put('/{combo}', [ComboController::class, 'update'])->name('combos.update');
    Route::delete('/{combo}', [ComboController::class, 'destroy'])->name('combos.destroy');
});
