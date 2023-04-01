<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RukoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::get('/home', function(){
    if (Auth::user()->role == 'A' || Auth::user()->role == 'M') {
        return redirect('dashboard');
    } else {return redirect('/');}
});

Route::get('/login', function() {
    if (Auth::user()->role == 'A' || Auth::user()->role == 'M') {
        return redirect('dashboard');
    } else {return redirect('/');}
});

Route::post('/login', [AuthController::class, 'authenticate'])->name('login.auth')->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    #Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::group(['middleware' => 'role:A'], function() {
        #Ruko
        Route::prefix('ruko')->name('ruko.')->group(function() {
            // Route::get('/', [RukoController::class, 'index'])->name('index');
            // Route::get('/create', [RukoController::class, 'create'])->name('index');
            Route::resource('/', RukoController::class);
        });
    });
});


