<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TanahController; // Controller tunggal untuk Tanah

// Controller spesifik untuk Tawang
use App\Http\Controllers\RoomController;
use App\Http\Controllers\InventarisController;

// Controller spesifik untuk Lengkongsari
use App\Http\Controllers\RklController;
use App\Http\Controllers\IklController;

// Controller spesifik untuk Cikalang
use App\Http\Controllers\RkcController;
use App\Http\Controllers\IkcController;

// Controller spesifik untuk Empang
use App\Http\Controllers\RkeController;
use App\Http\Controllers\IkeController;

// Controller spesifik untuk Kahuripan
use App\Http\Controllers\RkkController;
use App\Http\Controllers\IkkController;

// Controller spesifik untuk Tawangsari
use App\Http\Controllers\RktController;
use App\Http\Controllers\IktController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK & AUTENTIKASI ---
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTE YANG MEMBUTUHKAN AUTENTIKASI ---
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- RUTE DINAMIS HANYA UNTUK TANAH ---
    Route::prefix('{lokasi}')
        ->whereIn('lokasi', ['tawang', 'lengkongsari', 'cikalang', 'empang', 'kahuripan', 'tawangsari'])
        ->name('lokasi.')
        ->group(function () {
            Route::get('tanah/print', [TanahController::class, 'print'])->name('tanah.print');
            Route::resource('tanah', TanahController::class);
        });

    // --- RUTE STATIS UNTUK RUANGAN & INVENTARIS (PER LOKASI) ---

    // TAWANG
    Route::prefix('tawang')->name('tawang.')->group(function () {
        Route::get('/room/pdf', [RoomController::class, 'pdf'])->name('room.pdf');
        Route::resource('room', RoomController::class);
        Route::put('/inventaris/{inventaris}/move', [InventarisController::class, 'move'])->name('inventaris.move');
        Route::get('/inventaris/print', [InventarisController::class, 'pdf'])->name('inventaris.print');
        Route::resource('inventaris', InventarisController::class);
    });

    // LENGKONGSARI
    Route::prefix('lengkongsari')->name('lengkongsari.')->group(function () {
        Route::get('/rkl/pdf', [RklController::class, 'pdf'])->name('rkl.pdf');
        Route::resource('rkl', RklController::class);
        Route::put('/ikl/{ikl}/move', [IklController::class, 'move'])->name('ikl.move');
        Route::get('/ikl/print', [IklController::class, 'pdf'])->name('ikl.print');
        Route::resource('ikl', IklController::class);
    });

    // CIKALANG
    Route::prefix('cikalang')->name('cikalang.')->group(function () {
        Route::get('/rkc/pdf', [RkcController::class, 'pdf'])->name('rkc.pdf');
        Route::resource('rkc', RkcController::class);
        Route::put('/ikc/{ikc}/move', [IkcController::class, 'move'])->name('ikc.move');
        Route::get('/ikc/print', [IkcController::class, 'pdf'])->name('ikc.print');
        Route::resource('ikc', IkcController::class);
    });

    // EMPANG
    Route::prefix('empang')->name('empang.')->group(function () {
        Route::get('/rke/pdf', [RkeController::class, 'pdf'])->name('rke.pdf');
        Route::resource('rke', RkeController::class);
        Route::put('/ike/{ike}/move', [IkeController::class, 'move'])->name('ike.move');
        Route::get('/ike/print', [IkeController::class, 'pdf'])->name('ike.print');
        Route::resource('ike', IkeController::class);
    });

    // KAHURIPAN
    Route::prefix('kahuripan')->name('kahuripan.')->group(function () {
        Route::get('/rkk/pdf', [RkkController::class, 'pdf'])->name('rkk.pdf');
        Route::resource('rkk', RkkController::class);
        Route::put('/ikk/{ikk}/move', [IkkController::class, 'move'])->name('ikk.move');
        Route::get('/ikk/print', [IkkController::class, 'pdf'])->name('ikk.print');
        Route::resource('ikk', IkkController::class);
    });

    // TAWANGSARI
    Route::prefix('tawangsari')->name('tawangsari.')->group(function () {
        Route::get('/rkt/pdf', [RktController::class, 'pdf'])->name('rkt.pdf');
        Route::resource('rkt', RktController::class);
        Route::put('/ikt/{ikt}/move', [IktController::class, 'move'])->name('ikt.move');
        Route::get('/ikt/print', [IktController::class, 'pdf'])->name('ikt.print');
        Route::resource('ikt', IktController::class);
    });
});

