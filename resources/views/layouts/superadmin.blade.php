<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering MBG - Superadmin</title>
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
        .sidebar.collapsed { width: 72px; }
        .sidebar.collapsed .sidebar-brand h2 { display: none; }
        .sidebar.collapsed .sidebar-brand span { display: none; }
        .sidebar.collapsed .menu-label { display: none; }
        .sidebar.collapsed .sidebar-menu a span { display: none; }
        .sidebar.collapsed .sidebar-menu a { justify-content: center; padding: 10px; }
        .sidebar.collapsed .sidebar-menu a i { font-size: 20px; margin: 0; }
        .sidebar.collapsed .sidebar-brand { justify-content: center; padding: 16px; }
        .sidebar.collapsed .sidebar-brand .brand-icon { margin: 0; }
        
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
        
        .sidebar-brand {
            padding: 16px 20px;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }
        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: #F59E0B;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #0f172a;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-brand h2 { color: #f8fafc; font-size: 18px; font-weight: 700; white-space: nowrap; }
        .sidebar-brand h2 span { color: #F59E0B; }
        
        .sidebar-menu { padding: 12px 12px; }
        .sidebar-menu .menu-label {
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 12px 4px;
            font-weight: 600;
            white-space: nowrap;
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
        .sidebar-menu a i { width: 20px; font-size: 16px; flex-shrink: 0; text-align: center; }
        
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .sidebar.collapsed ~ .main-content { margin-left: 72px; }
        
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
        .topbar .left-section { display: flex; align-items: center; gap: 16px; }
        .topbar .left-section h1 { font-size: 18px; font-weight: 600; color: #0f172a; }
        .topbar .user-info { display: flex; align-items: center; gap: 16px; }
        .topbar .user-info .avatar {
            width: 36px; height: 36px; border-radius: 50%; background: #F59E0B;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
        }
        .sidebar-toggle {
            background: none; border: none; font-size: 20px; color: #0f172a;
            cursor: pointer; padding: 8px; border-radius: 8px; transition: background 0.2s;
        }
        .sidebar-toggle:hover { background: #f1f5f9; }
        .page-content { padding: 24px 32px; }
        .sidebar-toggle-mobile { display: none; }
        
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
            .sidebar.collapsed.open .sidebar-menu a { justify-content: flex-start; padding: 10px 14px; }
            
            .main-content { margin-left: 0 !important; }
            .topbar { padding: 12px 16px; }
            .page-content { padding: 16px; }
            .sidebar-toggle-mobile { display: block !important; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">MBG</div>
        <h2>Catering <span>MBG</span></h2>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-label">Main Menu</div>
        <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
        </a>
        <div class="menu-label">Manajemen</div>
        <a href="{{ route('superadmin.pengguna') }}" class="{{ request()->routeIs('superadmin.pengguna') ? 'active' : '' }}">
            <i class="fas fa-users"></i> <span>Kelola Pengguna</span>
        </a>
        <a href="{{ route('superadmin.catering') }}" class="{{ request()->routeIs('superadmin.catering') ? 'active' : '' }}">
            <i class="fas fa-store"></i> <span>Semua Catering</span>
        </a>
        <a href="{{ route('superadmin.pesanan') }}" class="{{ request()->routeIs('superadmin.pesanan') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i> <span>Semua Pesanan</span>
        </a>
        <div class="menu-label">Akun</div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </nav>
</aside>

<div class="main-content" id="mainContent">
    <header class="topbar">
        <div class="left-section">
            <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <button class="sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile" title="Open Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>{{ $pageTitle ?? 'Dashboard Superadmin' }}</h1>
        </div>
        <div class="user-info">
            <span>{{ Auth::user()->username ?? 'Superadmin' }}</span>
            <div class="avatar">{{ substr(Auth::user()->username ?? 'S', 0, 1) }}</div>
        </div>
    </header>
    <div class="page-content">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-4 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-4 text-sm text-red-700">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const toggleMobile = document.getElementById('sidebarToggleMobile');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });

    toggleMobile.addEventListener('click', function() {
        sidebar.classList.toggle('open');
    });

    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar.classList.contains('open') && 
            !sidebar.contains(e.target) && !toggleMobile.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
</script>

</body>
</html>