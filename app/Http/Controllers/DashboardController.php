<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Models\Tanah;
use App\Models\Peralatan;
use App\Models\Gedung;
use App\Models\Jalan;
use App\Models\Rusak;
use App\Models\Inventaris;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('pages/dashboard' );
    }
}

