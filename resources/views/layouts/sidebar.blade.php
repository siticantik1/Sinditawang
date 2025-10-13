@php
    // Mengambil semua data ruangan sekali saja untuk efisiensi, dikelompokkan berdasarkan lokasi
    $allRoomsByLocation = \App\Models\Room::orderBy('name')->get()->groupBy('lokasi');

    // Menyiapkan data untuk Tawang secara spesifik
    $tawangRooms = $allRoomsByLocation['tawang'] ?? collect();

    // Menyiapkan data untuk semua kelurahan
    $allKelurahan = [
        ['name' => 'Lengkongsari', 'slug' => 'lengkongsari'],
        ['name' => 'Cikalang', 'slug' => 'cikalang'],
        ['name' => 'Empang', 'slug' => 'empang'],
        ['name' => 'Kahuripan', 'slug' => 'kahuripan'],
        ['name' => 'Tawangsari', 'slug' => 'tawangsari'],
    ];
@endphp

<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    {{-- REVISI: Menambahkan logo di samping brand text --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            {{-- Pastikan logo ada di folder public/img/tsk.png --}}
            <img src="{{ asset('img/tsk.png') }}" alt="Logo Pemkot Tasikmalaya" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-2">SINDI</div>
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
    <li class="nav-item {{ request()->is('tawang/room*') && !request()->is('tawang/room/*/inventaris*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lokasi.room.index', ['lokasi' => 'tawang']) }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Ruangan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('tawang/room/*/inventaris*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventarisTawang" aria-expanded="true" aria-controls="collapseInventarisTawang">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        <div id="collapseInventarisTawang" class="collapse {{ request()->is('tawang/room/*/inventaris*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                @forelse ($tawangRooms as $room)
                    <a class="collapse-item {{ request()->route('room') && request()->route('room')->id == $room->id ? 'active' : '' }}"
                       href="{{ route('lokasi.inventaris.index', ['lokasi' => 'tawang', 'room' => $room->id]) }}">
                        {{ $room->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('lokasi.room.create', ['lokasi' => 'tawang']) }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('tawang/tanah*') || request()->is('tawang/peralatan*') || request()->is('tawang/gedung*') || request()->is('tawang/jalan*') || request()->is('tawang/rusak*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebarang" aria-expanded="true" aria-controls="collapsebarang">
            <i class="fas fa-fw fa-archive"></i>
            <span>Kartu Inventaris Barang</span>
        </a>
        <div id="collapsebarang" class="collapse {{ request()->is('tawang/tanah*') || request()->is('tawang/peralatan*') || request()->is('tawang/gedung*') || request()->is('tawang/jalan*') || request()->is('tawang/rusak*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Data:</h6>
                <a class="collapse-item" href="{{ route('lokasi.tanah.index', ['lokasi' => 'tawang']) }}">Tanah</a>
                <a class="collapse-item" href="{{ route('lokasi.peralatan.index', ['lokasi' => 'tawang']) }}">Peralatan & Mesin</a>
                <a class="collapse-item" href="{{ route('lokasi.gedung.index', ['lokasi' => 'tawang']) }}">Gedung & Bangunan</a>
                <a class="collapse-item" href="{{ route('lokasi.jalan.index', ['lokasi' => 'tawang']) }}">Jalan, Irigasi & Jaringan</a>
                <a class="collapse-item" href="{{ route('lokasi.rusak.index', ['lokasi' => 'tawang']) }}">Barang Rusak</a>
            </div>
        </div>
    </li>
    <!--====  End of MENU KECAMATAN TAWANG  ====-->


    <!--========================================
    =            LOOP MENU KELURAHAN             =
    =========================================-->
    @foreach ($allKelurahan as $kelurahan)
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Kelurahan {{ $kelurahan['name'] }}
        </div>
        
        <li class="nav-item {{ request()->is($kelurahan['slug'] . '/room*') && !request()->is($kelurahan['slug'] . '/room/*/inventaris*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('lokasi.room.index', ['lokasi' => $kelurahan['slug']]) }}">
                <i class="fas fa-fw fa-door-closed"></i>
                <span>Data Ruangan</span>
            </a>
        </li>
    
        <li class="nav-item {{ request()->is($kelurahan['slug'] . '/room/*/inventaris*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventori{{ ucfirst($kelurahan['slug']) }}" aria-expanded="true" aria-controls="collapseInventori{{ ucfirst($kelurahan['slug']) }}">
                <i class="fas fa-fw fa-boxes"></i>
                <span>Data Inventori Ruangan</span>
            </a>
            <div id="collapseInventori{{ ucfirst($kelurahan['slug']) }}" class="collapse {{ request()->is($kelurahan['slug'] . '/room/*/inventaris*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilih Ruangan:</h6>
                    @forelse ($allRoomsByLocation[$kelurahan['slug']] ?? [] as $room)
                        <a class="collapse-item {{ request()->route('room') && request()->route('room')->id == $room->id ? 'active' : '' }}"
                           href="{{ route('lokasi.inventaris.index', ['lokasi' => $kelurahan['slug'], 'room' => $room->id]) }}">
                            {{ $room->name }}
                        </a>
                    @empty
                        <a class="collapse-item" href="{{ route('lokasi.room.create', ['lokasi' => $kelurahan['slug']]) }}">Tambah Ruangan Dulu</a>
                    @endforelse
                </div>
            </div>
        </li>
    
        <li class="nav-item {{ request()->is($kelurahan['slug'] . '/tanah*') || request()->is($kelurahan['slug'] . '/peralatan*') || request()->is($kelurahan['slug'] . '/gedung*') || request()->is($kelurahan['slug'] . '/jalan*') || request()->is($kelurahan['slug'] . '/rusak*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarang{{ ucfirst($kelurahan['slug']) }}" aria-expanded="true" aria-controls="collapseBarang{{ ucfirst($kelurahan['slug']) }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Kartu Inventaris Barang</span>
            </a>
            <div id="collapseBarang{{ ucfirst($kelurahan['slug']) }}" class="collapse {{ request()->is($kelurahan['slug'] . '/tanah*') || request()->is($kelurahan['slug'] . '/peralatan*') || request()->is($kelurahan['slug'] . '/gedung*') || request()->is($kelurahan['slug'] . '/jalan*') || request()->is($kelurahan['slug'] . '/rusak*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilih Data:</h6>
                    <a class="collapse-item" href="{{ route('lokasi.tanah.index', ['lokasi' => $kelurahan['slug']]) }}">Tanah</a>
                    <a class="collapse-item" href="{{ route('lokasi.peralatan.index', ['lokasi' => $kelurahan['slug']]) }}">Peralatan & Mesin</a>
                    <a class="collapse-item" href="{{ route('lokasi.gedung.index', ['lokasi' => $kelurahan['slug']]) }}">Gedung & Bangunan</a>
                    <a class="collapse-item" href="{{ route('lokasi.jalan.index', ['lokasi' => $kelurahan['slug']]) }}">Jalan, Irigasi & Jaringan</a>
                    <a class="collapse-item" href="{{ route('lokasi.rusak.index', ['lokasi' => $kelurahan['slug']]) }}">Barang Rusak</a>
                </div>
            </div>
        </li>
    @endforeach
    <!--====  End of LOOP MENU KELURAHAN  ====-->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan & Pengaturan
    </div>

    <!-- Nav Item - Laporan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan Keseluruhan</span>
        </a>
    </li>

    <!-- Nav Item - Account -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Account</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

