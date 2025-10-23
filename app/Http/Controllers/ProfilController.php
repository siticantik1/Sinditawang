<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage; // Dihapus karena updatePhoto() dihapus
use Illuminate\Validation\Rule;
use App\Models\User; // Pastikan Anda mengimpor model User

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // View 'profile.edit' sudah menggunakan Auth::user() secara langsung,
        // jadi kita hanya perlu me-return view-nya.
        // Anda bisa menambahkan data 'log aktivitas' di sini jika perlu.
        return view('profile.edit');
    }

    /**
     * Update informasi dasar profil pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */ // <-- REVISI: Menambahkan type-hint untuk Intelephense
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Pastikan email unik, kecuali untuk user ini sendiri
            ],
            // Validasi untuk 'nip' dan 'jabatan' dihapus
        ]);

        // Asumsi kolom 'nip' dan 'jabatan' ada di tabel 'users' Anda
        $user->name = $request->name;
        $user->email = $request->email;
        // Baris untuk 'nip' dan 'jabatan' dihapus
        
        $user->save(); // Garis merah seharusnya hilang sekarang

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */ // <-- REVISI: Menambahkan type-hint untuk Intelephense
        $user = Auth::user();

        // 1. Validasi input
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan mencocokkan dengan 'password_confirmation'
        ]);

        // 2. Cek apakah password saat ini cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini tidak sesuai.');
        }

        // 3. Update password baru
        $user->password = Hash::make($request->password);
        $user->save(); // Garis merah seharusnya hilang sekarang

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Fungsi updatePhoto() dihapus seluruhnya karena
     * 'profile_photo_path' tidak ada di model User Anda.
     */
    // public function updatePhoto(Request $request) { ... }
}

