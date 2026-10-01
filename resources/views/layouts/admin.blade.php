<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering MBG - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F59E0B',
                        secondary: '#FFF7ED',
                        accent: '#6B8E23',
                        textcolor: '#374151',
                        sidebar: '#1e293b',
                        sidebarHover: '#334155'
                    }
                }
            }
        }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        
        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #0f172a;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 50;
            transition: width 0.3s ease;
        }
        /* Sidebar collapsed */
        .sidebar.collapsed {
            width: 72px;
        }
        .sidebar.collapsed .sidebar-brand { justify-content: center; padding: 14px 8px; }
        .sidebar.collapsed .sidebar-brand h2 { display: none; }
        .sidebar.collapsed .sidebar-brand span { display: none; }
        .sidebar.collapsed .sidebar-brand .sidebar-toggle-btn { display: none; }
        .sidebar.collapsed .sidebar-brand .brand-icon { margin: 0; cursor: pointer; }
        .sidebar.collapsed .menu-label { display: none; }
        .sidebar.collapsed .sidebar-menu a span { display: none; }
        .sidebar.collapsed .sidebar-menu a .badge { display: none; }
        .sidebar.collapsed .sidebar-menu a { justify-content: center; padding: 10px; }
        .sidebar.collapsed .sidebar-menu a i { font-size: 20px; margin: 0; }
        
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
        
        .sidebar-brand {
            padding: 14px 16px;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        .sidebar-brand .brand-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand .brand-icon {
            width: 38px;
            height: 38px;
            background: #F59E0B;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #0f172a;
            font-weight: 700;
            flex-shrink: 0;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .sidebar.collapsed .sidebar-brand .brand-icon:hover {
            transform: scale(1.08);
        }
        .sidebar-brand h2 {
            color: #f8fafc;
            font-size: 17px;
            font-weight: 700;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }
        .sidebar-brand h2 span { color: #F59E0B; }
        .sidebar-toggle-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-toggle-btn:hover {
            background: #1e293b;
            color: #f8fafc;
        }
        
        .sidebar-menu { padding: 12px 12px; }
        .sidebar-menu .menu-label {
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 12px 4px;
            font-weight: 600;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #94a3b8;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .sidebar-menu a:hover { background: #1e293b; color: #f8fafc; }
        .sidebar-menu a.active { background: #F59E0B; color: #0f172a; }
        .sidebar-menu a i {
            width: 20px;
            font-size: 16px;
            flex-shrink: 0;
            text-align: center;
        }
        .sidebar-menu a .badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 12px;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 72px;
        }
        
        /* ===== TOPBAR ===== */
        .topbar {
            background: white;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar .left-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar .left-section h1 {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }
        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar .user-info .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #F59E0B;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .topbar .user-info span { font-size: 14px; color: #1e293b; }
        
        /* ===== TOGGLE BUTTON ===== */
        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 20px;
            color: #0f172a;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .sidebar-toggle:hover { background: #f1f5f9; }
        
        /* ===== PAGE CONTENT ===== */
        .page-content { padding: 24px 32px; }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px !important;
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar.collapsed { transform: translateX(-100%); }
            .sidebar.collapsed.open { transform: translateX(0); width: 280px !important; }
            .sidebar.collapsed.open .sidebar-brand h2 { display: block; }
            .sidebar.collapsed.open .menu-label { display: block; }
            .sidebar.collapsed.open .sidebar-menu a span { display: inline; }
            .sidebar.collapsed.open .sidebar-menu a .badge { display: inline; }
            .sidebar.collapsed.open .sidebar-menu a { justify-content: flex-start; padding: 10px 14px; }
            
            .main-content { margin-left: 0 !important; }
            .sidebar ~ .main-content { margin-left: 0 !important; }
            .topbar { padding: 12px 16px; }
            .page-content { padding: 16px; }
            .sidebar-toggle-mobile { display: block !important; }
        }
        .sidebar-toggle-mobile { display: none; }
    </style>
</head>
<body>

<!-- ============ SIDEBAR ============ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-info">
            <div class="brand-icon" id="brandIcon" title="Toggle Sidebar">MBG</div>
            <h2>Catering <span>MBG</span></h2>
        </div>
        <button class="sidebar-toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-label">Main Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
        </a>
        
        @if(Auth::user()->status === 'Aktif')
            <a href="{{ route('admin.catering.profile') }}" class="{{ request()->routeIs('admin.catering.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i> <span>Profil Catering</span>
            </a>
            
            <div class="menu-label">Manajemen</div>
            <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">
                <i class="fas fa-utensils"></i> <span>Kelola Menu</span>
            </a>
            <a href="{{ route('paket.index') }}" class="{{ request()->routeIs('paket.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> <span>Kelola Paket</span>
            </a>
            
            <div class="menu-label">Transaksi</div>
            @php
                $adminCateringId = auth()->user()->catering?->id ?? auth()->user()->id_catering ?? 0;
                $pesananMasukCount = \App\Models\Pesanan::where('id_catering', $adminCateringId)
                    ->whereIn('status_pesanan', ['Pending', 'Diproses'])
                    ->count();
            @endphp
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> <span>Pesanan Masuk</span>
                @if($pesananMasukCount > 0)
                    <span class="badge">{{ $pesananMasukCount }}</span>
                @endif
            </a>
            
            <div class="menu-label">Laporan</div>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> <span>Laporan Penjualan</span>
            </a>
        @endif
        
        <div class="menu-label">Akun</div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </nav>
</aside>

<!-- ============ MAIN CONTENT ============ -->
<div class="main-content" id="mainContent">
    <!-- Topbar -->
    <header class="topbar">
        <div class="left-section">
            <!-- TOMBOL 3 GARIS UNTUK MOBILE -->
            <button class="sidebar-toggle-mobile" id="sidebarToggleMobile" title="Open Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
        </div>
        <div class="user-info">
            <div class="text-right hidden sm:block">
                <span class="block font-semibold text-sm text-gray-800">{{ Auth::user()->username ?? 'Admin' }}</span>
                @if(Auth::user()?->catering)
                    <span class="block text-xs text-orange-600 font-medium">{{ Auth::user()->catering->nama_catering }}</span>
                @endif
            </div>
            @if(Auth::user()?->catering?->foto)
                <img src="{{ asset('storage/' . Auth::user()->catering->foto) }}" alt="Avatar" class="avatar object-cover border border-amber-300 shadow-sm">
            @else
                <div class="avatar">{{ substr(Auth::user()->username ?? 'A', 0, 1) }}</div>
            @endif
        </div>
    </header>

    <!-- Page Content -->
    <div class="page-content">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif
        @yield('admin_content')
    </div>
</div>

<script>
    // ===== SIDEBAR COLLAPSE =====
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const brandIcon = document.getElementById('brandIcon');
    const toggleMobile = document.getElementById('sidebarToggleMobile');
    const mainContent = document.getElementById('mainContent');

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
    if (brandIcon) {
        brandIcon.addEventListener('click', function() {
            if (sidebar.classList.contains('collapsed')) {
                toggleSidebar();
            }
        });
    }

    // Toggle mobile
    if (toggleMobile) {
        toggleMobile.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    // Load saved state
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar.classList.contains('open') && 
            !sidebar.contains(e.target) && !toggleMobile.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
</script>

</body>
</html>