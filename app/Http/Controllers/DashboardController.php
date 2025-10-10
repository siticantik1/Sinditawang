<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Baris ini akan menampilkan file view 'dashboard.blade.php'
        return view('pages/dashboard');
    }

    // ... Mungkin ada fungsi lain di sini ...
}