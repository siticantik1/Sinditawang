@php
    // Data untuk Kecamatan Tawang (kasus khusus)
    $tawangData = [
        'rooms' => \App\Models\Room::where('lokasi', 'tawang')->orderBy('name')->get(),
    ];

    // Menyiapkan data untuk semua kelurahan agar bisa di-looping
    $allKelurahan = [
        [
            'name' => 'Lengkongsari',
            'slug' => 'lengkongsari',
            'rooms' => \App\Models\Rkl::where('lokasi', 'lengkongsari')->orderBy('name')->get(),
            'room_key' => 'rkl',
            'inventory_key' => 'ikl',
            'item_key' => 'barangl',
        ],
        [
            'name' => 'Cikalang',
            'slug' => 'cikalang',
            'rooms' => \App\Models\Rkc::where('lokasi', 'cikalang')->orderBy('name')->get(),
            'room_key' => 'rkc',
            'inventory_key' => 'ikc',
            'item_key' => 'barangc',
        ],
        [
            'name' => 'Empang',
            'slug' => 'empang',
            'rooms' => \App\Models\Rke::where('lokasi', 'empang')->orderBy('name')->get(),
            'room_key' => 'rke',
            'inventory_key' => 'ike',
            'item_key' => 'barange',
        ],
        [
            'name' => 'Kahuripan',
            'slug' => 'kahuripan',
            'rooms' => \App\Models\Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get(),
            'room_key' => 'rkk',
            'inventory_key' => 'ikk',
            'item_key' => 'barangk',
        ],
        [
            'name' => 'Tawangsari',
            'slug' => 'tawangsari',
            'rooms' => \App\Models\Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get(),
            'room_key' => 'rkt',
            'inventory_key' => 'ikt',
            'item_key' => 'barangt',
        ],
    ];
@endphp

<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

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

    <!--============================================
    =            MENU KECAMATAN TAWANG             =
    =============================================-->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kecamatan Tawang
    </div>
    <li class="nav-item {{ request()->is('tawang/room*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tawang.room.index') }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Ruangan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('tawang/inventaris*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventarisTawang" aria-expanded="true" aria-controls="collapseInventarisTawang">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseInventarisTawang" class="collapse {{ request()->is('tawang/inventaris*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($tawangData['rooms'] as $room)
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
                <a class="collapse-item" href="#">Jalan</a>
                <a class="collapse-item" href="#">Rusak Berat</a>
            </div>
        </div>
    </li>
    <!--====  End of MENU KECAMATAN TAWANG  ====-->


    <!--========================================
    =            LOOP MENU KELURAHAN           =
    =========================================-->
    @foreach ($allKelurahan as $kelurahan)
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Kelurahan {{ $kelurahan['name'] }}
        </div>
        
        <!-- Nav Item - Data Ruangan -->
        <li class="nav-item {{ request()->is($kelurahan['slug'] . '/' . $kelurahan['room_key'] . '*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($kelurahan['slug'] . '.' . $kelurahan['room_key'] . '.index') }}">
                <i class="fas fa-fw fa-door-closed"></i>
                <span>Data Ruangan</span>
            </a>
        </li>
    
        <!-- Nav Item - Data Inventori Ruangan (Collapse) -->
        <li class="nav-item {{ request()->is($kelurahan['slug'] . '/' . $kelurahan['inventory_key'] . '*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventori{{ ucfirst($kelurahan['slug']) }}" aria-expanded="true" aria-controls="collapseInventori{{ ucfirst($kelurahan['slug']) }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Data Inventori Ruangan</span>
            </a>
            <div id="collapseInventori{{ ucfirst($kelurahan['slug']) }}" class="collapse {{ request()->is($kelurahan['slug'] . '/' . $kelurahan['inventory_key'] . '*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilih Ruangan:</h6>
                    @forelse ($kelurahan['rooms'] as $room)
                        <a class="collapse-item {{ request($kelurahan['room_key'] . '_id') == $room->id ? 'active' : '' }}"
                           href="{{ route($kelurahan['slug'] . '.' . $kelurahan['inventory_key'] . '.index', [$kelurahan['room_key'] . '_id' => $room->id]) }}">
                            {{ $room->name }}
                        </a>
                    @empty
                        <a class="collapse-item" href="{{ route($kelurahan['slug'] . '.' . $kelurahan['room_key'] . '.create') }}">Tambah Ruangan Dulu</a>
                    @endforelse
                </div>
            </div>
        </li>
    
        <!-- Nav Item - Data Barang (Collapse) -->
        <li class="nav-item {{ request()->is($kelurahan['item_key'] . '*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarang{{ ucfirst($kelurahan['slug']) }}" aria-expanded="true" aria-controls="collapseBarang{{ ucfirst($kelurahan['slug']) }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Data Barang</span>
            </a>
            <div id="collapseBarang{{ ucfirst($kelurahan['slug']) }}" class="collapse {{ request()->is($kelurahan['item_key'] . '*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilih Data:</h6>
                    <a class="collapse-item" href="#">Tanah</a>
                    <a class="collapse-item" href="#">Peralatan & Mesin</a>
                    <a class="collapse-item" href="#">Gedung & Bangunan</a>
                    <a class="collapse-item" href="#">Jalan</a>
                    <a class="collapse-item" href="#">Rusak Berat</a>
                </div>
            </div>
        </li>
    @endforeach
    <!--====  End of LOOP MENU KELURAHAN  ====-->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

