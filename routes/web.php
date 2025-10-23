<?php

use Illuminate\Support\Facades\Route;

// --- CONTROLLER UTAMA & AUTENTIKASI ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController; // Import Controller baru
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// --- CONTROLLER DINAMIS (SATU UNTUK SEMUA) ---
use App\Http\Controllers\TanahController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\RusakController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK & AUTENTIKASI ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');


// --- RUTE YANG MEMBUTUHKAN AUTENTIKASI ---
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // REVISI: Rute Profil (untuk user yang sedang login)
    // Menggunakan prefix /profile agar tidak bentrok dengan /user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    // Hapus: Route::resource('user', ProfilController::class); // <-- Dihapus karena bentrok

    // REVISI: Tambahkan rute untuk menandai notifikasi sudah dibaca
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Rute Manajemen User (untuk admin)
    Route::resource('user', UserController::class);

    // --- RUTE DINAMIS UNTUK SEMUA MODUL ---
    Route::prefix('{lokasi}')
        ->whereIn('lokasi', ['tawang', 'lengkongsari', 'cikalang', 'empang', 'kahuripan', 'tawangsari'])
        ->name('lokasi.')
        ->middleware('lokasi.access') // <--- PEMBARUAN: MIDDLEWARE DITERAPKAN DI SINI
        ->group(function () {
            
            // Route untuk export Excel
            Route::get('export/{menu}', [ExportController::class, 'export'])->name('export.excel');

            // Route untuk Ruangan (DINAMIS)
            Route::get('room/print', [RoomController::class, 'print'])->name('room.print');
            Route::resource('room', RoomController::class);

            // Route untuk Inventaris (DINAMIS & BERSARANG)
            Route::get('room/{room}/inventaris/print', [InventarisController::class, 'print'])->name('inventaris.print');
            Route::post('room/{room}/inventaris/{inventari}/move', [InventarisController::class, 'move'])->name('inventaris.move');
            Route::resource('room/{room}/inventaris', InventarisController::class)->names('inventaris');

            // Route untuk KIB
            Route::get('tanah/print', [TanahController::class, 'print'])->name('tanah.print');
            Route::resource('tanah', TanahController::class);
            Route::get('peralatan/print', [PeralatanController::class, 'print'])->name('peralatan.print');
            Route::resource('peralatan', PeralatanController::class);
            Route::get('gedung/print', [GedungController::class, 'print'])->name('gedung.print');
            Route::resource('gedung', GedungController::class);
            Route::get('jalan/print', [JalanController::class, 'print'])->name('jalan.print');
            Route::resource('jalan', JalanController::class);
            Route::get('rusak/print', [RusakController::class, 'print'])->name('rusak.print');
            Route::resource('rusak', RusakController::class);
        });
});
