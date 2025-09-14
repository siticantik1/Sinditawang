@php 
    $roomsTawang = \App\Models\Room::where('lokasi', 'tawang')->orderBy('name')->get();
    $rklsLengkongsari = \App\Models\Rkl::where('lokasi', 'lengkongsari')->orderBy('name')->get();
    $rkcsCikalang = \App\Models\Rkc::where('lokasi', 'cikalang')->orderBy('name')->get();
    $rkesEmpang = \App\Models\Rke::where('lokasi', 'empang')->orderBy('name')->get();
    $rkksKahuripan = \App\Models\Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get();
    $rktsTawangsari = \App\Models\Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get(); // Ditambahkan untuk Tawangsari
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-text mx-3">SINDI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kecamatan Tawang
    </div>

    <!-- Nav Item - Data Ruangan Tawang -->
    <li class="nav-item {{ request()->is('tawang/room*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tawang.room.index') }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Tawang (Collapse) -->
    <li class="nav-item {{ request()->is('tawang/inventaris*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventarisTawang" aria-expanded="true" aria-controls="collapseInventarisTawang">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseInventarisTawang" class="collapse {{ request()->is('tawang/inventaris*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($roomsTawang as $room)
                    <a class="collapse-item {{ request('room_id') == $room->id ? 'active' : '' }}"
                       href="{{ route('tawang.inventaris.index', ['room_id' => $room->id]) }}">
                        {{ $room->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('tawang.room.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Tawang (Collapse) -->
    <li class="nav-item {{ request()->is('barang*') && !request()->is('barangl*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarang" aria-expanded="true" aria-controls="collapsebarang">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarang" class="collapse {{ request()->is('barang*') && !request()->is('barangl*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelurahan Lengkongsari
    </div>
    
    <!-- Nav Item - Data Ruangan Lengkongsari -->
    <li class="nav-item {{ request()->is('lengkongsari/rkl*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lengkongsari.rkl.index') }}">
            <i class="fas fa-fw fa-door-closed"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Lengkongsari (Collapse) -->
    <li class="nav-item {{ request()->is('lengkongsari/ikl*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIklLengkongsari" aria-expanded="true" aria-controls="collapseIklLengkongsari">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseIklLengkongsari" class="collapse {{ request()->is('lengkongsari/ikl*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($rklsLengkongsari as $rkl)
                    <a class="collapse-item {{ request('rkl_id') == $rkl->id ? 'active' : '' }}"
                       href="{{ route('lengkongsari.ikl.index', ['rkl_id' => $rkl->id]) }}">
                        {{ $rkl->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('lengkongsari.rkl.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Lengkongsari (Collapse) -->
    <li class="nav-item {{ request()->is('barangl*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarangl" aria-expanded="true" aria-controls="collapsebarangl">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarangl" class="collapse {{ request()->is('barangl*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelurahan Cikalang
    </div>
    
    <!-- Nav Item - Data Ruangan Cikalang -->
    <li class="nav-item {{ request()->is('cikalang/rkc*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('cikalang.rkc.index') }}">
            <i class="fas fa-fw fa-door-closed"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Cikalang (Collapse) -->
    <li class="nav-item {{ request()->is('cikalang/ikc*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIkcCikalang" aria-expanded="true" aria-controls="collapseIkcCikalang">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseIkcCikalang" class="collapse {{ request()->is('cikalang/ikc*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($rkcsCikalang as $rkc)
                    <a class="collapse-item {{ request('rkc_id') == $rkc->id ? 'active' : '' }}"
                       href="{{ route('cikalang.ikc.index', ['rkc_id' => $rkc->id]) }}">
                        {{ $rkc->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('cikalang.rkc.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Cikalang (Collapse) -->
    <li class="nav-item {{ request()->is('barangc*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarangc" aria-expanded="true" aria-controls="collapsebarangc">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarangc" class="collapse {{ request()->is('barangc*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelurahan Empang
    </div>
    
    <!-- Nav Item - Data Ruangan Empang -->
    <li class="nav-item {{ request()->is('empang/rke*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('empang.rke.index') }}">
            <i class="fas fa-fw fa-door-closed"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Empang (Collapse) -->
    <li class="nav-item {{ request()->is('empang/ike*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIkeEmpang" aria-expanded="true" aria-controls="collapseIkeEmpang">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseIkeEmpang" class="collapse {{ request()->is('empang/ike*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($rkesEmpang as $rke)
                    <a class="collapse-item {{ request('rke_id') == $rke->id ? 'active' : '' }}"
                       href="{{ route('empang.ike.index', ['rke_id' => $rke->id]) }}">
                        {{ $rke->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('empang.rke.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Empang (Collapse) -->
    <li class="nav-item {{ request()->is('barange*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarange" aria-expanded="true" aria-controls="collapsebarange">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarange" class="collapse {{ request()->is('barange*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelurahan Kahuripan
    </div>
    
    <!-- Nav Item - Data Ruangan Kahuripan -->
    <li class="nav-item {{ request()->is('kahuripan/rkk*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kahuripan.rkk.index') }}">
            <i class="fas fa-fw fa-door-closed"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Kahuripan (Collapse) -->
    <li class="nav-item {{ request()->is('kahuripan/ikk*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIkkKahuripan" aria-expanded="true" aria-controls="collapseIkkKahuripan">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseIkkKahuripan" class="collapse {{ request()->is('kahuripan/ikk*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($rkksKahuripan as $rkk)
                    <a class="collapse-item {{ request('rkk_id') == $rkk->id ? 'active' : '' }}"
                       href="{{ route('kahuripan.ikk.index', ['rkk_id' => $rkk->id]) }}">
                        {{ $rkk->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('kahuripan.rkk.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Kahuripan (Collapse) -->
    <li class="nav-item {{ request()->is('barangk*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarangk" aria-expanded="true" aria-controls="collapsebarangk">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarangk" class="collapse {{ request()->is('barangk*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelurahan Tawangsari
    </div>
    
    <!-- Nav Item - Data Ruangan Tawangsari -->
    <li class="nav-item {{ request()->is('tawangsari/rkt*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tawangsari.rkt.index') }}">
            <i class="fas fa-fw fa-door-closed"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan Tawangsari (Collapse) -->
    <li class="nav-item {{ request()->is('tawangsari/ikt*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIktTawangsari" aria-expanded="true" aria-controls="collapseIktTawangsari">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseIktTawangsari" class="collapse {{ request()->is('tawangsari/ikt*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($rktsTawangsari as $rkt)
                    <a class="collapse-item {{ request('rkt_id') == $rkt->id ? 'active' : '' }}"
                       href="{{ route('tawangsari.ikt.index', ['rkt_id' => $rkt->id]) }}">
                        {{ $rkt->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('tawangsari.rkt.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Nav Item - Data Barang Tawangsari (Collapse) -->
    <li class="nav-item {{ request()->is('barangt*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarangt" aria-expanded="true" aria-controls="collapsebarangt">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Barang</span>
        </a>
        <div id="collapsebarangt" class="collapse {{ request()->is('barangt*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="#">Tanah</a>
                <a class="collapse-item" href="#">Peralatan & Mesin</a>
                <a class="collapse-item" href="#">Gedung & Bangunan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

