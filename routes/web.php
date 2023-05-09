<?php

use App\Http\Controllers\ARController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembukuanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PenyewaController;
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
    Route::prefix('/dashboard')->name('dashboard.')->group(function() {
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/update', [DashboardController::class, 'update'])->name('update');
        Route::put('/password', [DashboardController::class, 'password'])->name('password');
    });

    Route::group(['middleware' => 'role:A'], function() {
        #Ruko
        Route::resource('ruko', RukoController::class)->except('show', 'create', 'edit');
        Route::put('/ruko/sewa/{ruko}', [RukoController::class, 'sewa'])->name('ruko.sewa');
        Route::put('/ruko/lepas/{ruko}', [RukoController::class, 'lepas'])->name('ruko.lepas');
        Route::resource('penyewa', PenyewaController::class)->except('show');
        Route::prefix('penyewa')->name('penyewa.')->group(function() {
            Route::post('/getregencies', [PenyewaController::class, 'get_regencies'])->name('regencies');
            Route::post('/getdistricts', [PenyewaController::class, 'get_districts'])->name('districts');
            Route::post('/getvillages', [PenyewaController::class, 'get_villages'])->name('villages');
        });
        Route::resource('pembayaran', PembayaranController::class)->except('create', 'edit', 'destroy');
        Route::get('/pembayaran/ruko/{id_ruko}', [PembayaranController::class, 'getdata'])->name('pembayaran.getdata');
        Route::get('/pembayaran/print/{id}', [PembayaranController::class, 'print'])->name('pembayaran.print');
        Route::prefix('pembukuan')->name('pembukuan.')->group(function() {
            Route::get('/', [PembukuanController::class, 'index'])->name('index');
            Route::get('/all', [PembukuanController::class, 'all'])->name('all');
            Route::get('/show', [PembukuanController::class, 'show'])->name('show');
            Route::get('/create', [PembukuanController::class, 'create'])->name('create');
            Route::post('/create', [PembukuanController::class, 'store'])->name('store');
            Route::get('/all/edit/{id}', [PembukuanController::class, 'edit'])->name('edit');
            Route::put('/all/edit/{id}', [PembukuanController::class, 'update'])->name('update');
            Route::delete('/all/delete/{id}', [PembukuanController::class, 'destroy'])->name('destroy');
        });
        Route::get('/ar/index', [ARController::class, 'index'])->name('ar.index');

        #Karyawan
        Route::resource('karyawan', KaryawanController::class)->except('show');
        Route::prefix('karyawan')->name('karyawan.')->group(function() {
            Route::post('/getregencies', [KaryawanController::class, 'get_regencies'])->name('regencies');
            Route::post('/getdistricts', [KaryawanController::class, 'get_districts'])->name('districts');
            Route::post('/getvillages', [KaryawanController::class, 'get_villages'])->name('villages');
        });
        Route::resource('penggajian', PenggajianController::class)->except('show', 'edit', 'destroy');
        Route::get('/penggajian/print/{id}', [PenggajianController::class, 'print'])->name('penggajian.print');

        #Inventaris
        Route::resource('inventaris', InventarisController::class)->except('show');
    });
});


