<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembukuanController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\RukoController;
use App\Models\Pembukuan;
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
        Route::resource('ruko', RukoController::class)->except('show', 'create', 'edit');
        Route::put('/ruko/sewa/{ruko}', [RukoController::class, 'sewa'])->name('ruko.sewa');
        Route::put('/ruko/lepas/{ruko}', [RukoController::class, 'lepas'])->name('ruko.lepas');
        Route::resource('penyewa', PenyewaController::class)->except('show');
        Route::prefix('penyewa')->group(function() {
            Route::post('/getregencies', [PenyewaController::class, 'get_regencies'])->name('penyewa.regencies');
            Route::post('/getdistricts', [PenyewaController::class, 'get_districts'])->name('penyewa.districts');
            Route::post('/getvillages', [PenyewaController::class, 'get_villages'])->name('penyewa.villages');
        });
        Route::resource('pembayaran', PembayaranController::class)->except('create', 'edit', 'update', 'destroy');
        Route::get('/pembayaran/ruko/{id_ruko}', [PembayaranController::class, 'getdata'])->name('pembayaran.getdata');
        Route::get('/pembayaran/print/{id}', [PembayaranController::class, 'print'])->name('pembayaran.print');
        Route::prefix('pembukuan')->name('pembukuan.')->group(function() {
            Route::get('/', [PembukuanController::class, 'index'])->name('index');
            Route::get('/all', [PembukuanController::class, 'all'])->name('all');
            Route::get('/show', [PembukuanController::class, 'show'])->name('show');
            Route::get('/create', [PembukuanController::class, 'create'])->name('create');
            Route::post('/create', [PembukuanController::class, 'store'])->name('store');
        });
    });
});


