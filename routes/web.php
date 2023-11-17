<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PickupCenterController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;

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
    if(Auth::user()){
        
        if(Auth::user()->user_type == 'admin')
        {
            return redirect()->route('home.admin');
        }
    }

    return view('auth.login');
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

Route::resource('states', StateController::class);
Route::resource('cities', CityController::class);
Route::resource('pickup-centers', PickupCenterController::class);


Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/regular', [UsersController::class, 'regular'])->name('regular.index');
    Route::get('/admins', [UsersController::class, 'admins'])->name('admins.index');
    Route::post('/manual-funding', [UsersController::class, 'manualFunding'])->name('manual-funding');
    Route::post('/change-password', [UsersController::class, 'changePassword'])->name('change-password');
    Route::delete('/{id}',  [UsersController::class, 'destroy'])->name('users.destroy');

    Route::post('/admin/submit',  [UsersController::class, 'storeAdmin'])->name('admin.store');


});