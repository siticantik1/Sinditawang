<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RklController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\IklController;
// Tambahkan controller untuk Cikalang
use App\Http\Controllers\RkcController;
use App\Http\Controllers\IkcController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// ROUTE UNTUK KECAMATAN TAWANG
Route::prefix('tawang')->name('tawang.')->group(function () {
    Route::get('/room/pdf', [RoomController::class, 'pdf'])->name('room.pdf');
    Route::resource('room', RoomController::class);

    // Rute custom untuk 'inventaris'
    Route::put('/inventaris/{inventaris}/move', [InventarisController::class, 'move'])->name('inventaris.move');
    Route::get('/inventaris/print', [InventarisController::class, 'pdf'])->name('inventaris.print');
    
    Route::resource('inventaris', InventarisController::class)
            ->parameters(['inventaris' => 'inventaris']);
});

// ROUTE UNTUK KELURAHAN LENGKONGSARI
Route::prefix('lengkongsari')->name('lengkongsari.')->group(function () {
    Route::get('/rkl/pdf', [RklController::class, 'pdf'])->name('rkl.pdf');
    Route::resource('rkl', RklController::class);

    Route::put('/ikl/{ikl}/move', [IklController::class, 'move'])->name('ikl.move');
    Route::get('/ikl/print', [IklController::class, 'pdf'])->name('ikl.print');
    
    Route::resource('ikl', IklController::class);
});

// ROUTE UNTUK KELURAHAN CIKALANG
Route::prefix('cikalang')->name('cikalang.')->group(function () {
    // Note: Anda perlu menambahkan method pdf() di RkcController jika diperlukan
    Route::get('/rkc/pdf', [RkcController::class, 'pdf'])->name('rkc.pdf');
    Route::resource('rkc', RkcController::class);

    Route::put('/ikc/{ikc}/move', [IkcController::class, 'move'])->name('ikc.move');
    Route::get('/ikc/print', [IkcController::class, 'pdf'])->name('ikc.print');
    
    Route::resource('ikc', IkcController::class);
});
